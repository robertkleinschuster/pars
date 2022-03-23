<?php

namespace Pars\Core\View;

use Pars\Core\Http\Stream\QueueStream;
use Psr\Http\Message\StreamInterface;
use Throwable;

class ViewRenderer
{
    protected ?ViewComponent $component = null;

    /**
     * @throws ViewException
     */
    public function render(): StreamInterface
    {
        if (!$this->component) {
            throw new ViewException('No component set!');
        }
        if ($this->component->isList()) {
            $result = $this->renderList($this->component);
        } else {
            $result = $this->renderComponent($this->component);
        }
        return $result;
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
            if ($component instanceof EntrypointInterface) {
                Entrypoints::add($component::getEntrypoint());
            }
            $component = clone $component;
            $component->onRender(clone $this);
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
                $throwable->getCode(),
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
            if ($child->isList()) {
                $queueStream->push($this->renderList($child));
            } else {
                $queueStream->push($this->renderComponent($child));
            }
        }

        return $queueStream;
    }

    /**
     * @param ViewComponent $component
     * @return QueueStream
     * @throws ViewException
     */
    private function renderList(ViewComponent $component): QueueStream
    {
        $queueStream = new QueueStream();
        foreach ($component->getModel()->getList() as $model) {
            $queueStream->push($this->renderComponent($component->withModel($model)));
        }
        return $queueStream;
    }
}
