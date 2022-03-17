<?php

namespace Pars\Core\View;

use Throwable;

class ViewRenderer
{
    protected ?ViewComponent $component = null;

    /**
     * @throws ViewException
     */
    public function render(): string
    {
        if (!$this->component) {
            throw new ViewException('No component set!');
        }
        if ($this->component->getModel()->isList()) {
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
     * @return string|void
     * @throws ViewException
     */
    protected function renderComponent(ViewComponent $component)
    {
        try {
            if ($component instanceof EntrypointInterface) {
                Entrypoints::add($component::getEntrypoint());
            }
            $component = clone $component;
            $component->onRender(clone $this);
            if (!$component->getContent()) {
                $component->setContent($this->renderChildren($component));
            }
            return trim($this->renderTemplate($component));
        } catch (Throwable $throwable) {
            $this->throwViewException($component, $throwable);
        }
    }

    protected function renderTemplate(ViewComponent $component)
    {
        $template = $component->getTemplate();
        return (function () use ($template) {
            ob_start();
            include $template;
            return ob_get_clean();
        })(...)->call($component);
    }


    private function renderChildren(ViewComponent $component): string
    {
        $result = '';

        foreach ($component->getChildren() as $child) {
            if ($child->isList()) {
                $result .= trim($this->renderList($child));
            } else {
                $result .= trim($this->renderComponent($child));
            }
        }

        return $result;
    }

    private function renderList(ViewComponent $component): string
    {
        $result = '';
        foreach ($component->getModel()->getList() as $model) {
            $result .= trim($this->renderComponent($component->withModel($model)));
        }
        return $result;
    }


    /**
     * @param ViewComponent $component
     * @param Throwable $throwable
     * @return mixed
     * @throws ViewException
     */
    private function throwViewException(ViewComponent $component, Throwable $throwable)
    {
        $componentClass = $component::class;
        throw new ViewException(
            "Error in '$componentClass': " . $throwable->getMessage(),
            $throwable->getCode(),
            $throwable
        );
    }
}
