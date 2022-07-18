<?php

namespace Pars\Core\View;

use Closure;
use Pars\Core\Http\Stream\ClosureStream;
use Pars\Core\Http\Stream\QueueStream;
use Psr\Http\Message\StreamInterface;
use Throwable;

class ViewRenderer
{
    protected ?ViewComponent $component = null;
    protected Entrypoints $entrypoints;

    public function __construct()
    {
        $this->entrypoints = new Entrypoints();
    }

    /**
     * @return Entrypoints
     */
    public function getEntrypoints(): Entrypoints
    {
        return $this->entrypoints;
    }

    /**
     * @throws ViewException
     */
    public function render(): StreamInterface
    {
        if (!$this->component) {
            throw new ViewException('No component set!');
        }
        return $this->renderComponent($this->component);
    }

    public function setComponent(ViewComponent $component): ViewRenderer
    {
        $this->component = $component;
        return $this;
    }

    /**
     * @param ViewComponent $component
     * @return StreamInterface
     * @throws ViewException
     */
    protected function renderComponent(ViewComponent $component): StreamInterface
    {
        try {
            $component = clone $component;

            $component->onRender(clone $this);

            if ($component instanceof EntrypointInterface) {
                $this->entrypoints->enable($component::getEntrypoint());
            }

            if ($component->isList()) {
                return $this->renderList($component);
            }

            if (!$component->getContent()) {
                $content = $this->renderChildren($component);
                if (!$content->isEmpty()) {
                    $component->setContent($content);
                }
            }
            return new ViewStream($component);
        } catch (Throwable $throwable) {
            $componentClass = $component::class;
            throw new ViewException(
                "$componentClass:" .
                " Error in '{$throwable->getFile()}' on line {$throwable->getLine()}: " .
                $throwable->getMessage(),
                (int)$throwable->getCode(),
                $throwable
            );
        }
    }

    /**
     * @param ViewComponent $component
     * @return QueueStream
     * @throws ViewException
     */
    private function renderChildren(ViewComponent $component): QueueStream
    {
        $queueStream = new QueueStream();

        foreach ($component->getChildren() as $child) {
            $queueStream->push($this->renderComponent($child));
        }

        return $queueStream;
    }

    /**
     * @param ViewComponent $component
     * @return StreamInterface
     */
    private function renderList(ViewComponent $component): StreamInterface
    {
        $function = function () use ($component) {
            foreach ($component->getModel()->getIterator() as $model) {
                echo $this->renderComponent($component->withModel($model));
            }
        };
        return new ClosureStream(Closure::fromCallable($function), $this);
    }
}
