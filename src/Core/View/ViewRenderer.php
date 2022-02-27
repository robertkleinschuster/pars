<?php

namespace Pars\Core\View;

class ViewRenderer
{
    protected ?ViewComponent $component = null;

    protected string $handler = '';

    public static array $entrypoints = [];

    public function render(): string
    {
        if (!$this->component) {
            throw new \Exception('No component set!');
        }
        if ($this->component->getModel()->isList()) {
            $result = $this->renderList($this->component);
        } else {
            $result = $this->renderComponent($this->component);
        }
        if ($this->handler) {
            $result = "<script data-handler='{$this->handler}'></script>$result";
        }
        return $result;
    }

    public function setComponent(ViewComponent $component): ViewRenderer
    {
        $this->component = $component;
        return $this;
    }

    protected function renderComponent(ViewComponent $component)
    {
        if ($component instanceof EntrypointInterface) {
            self::$entrypoints[] = Entrypoints::buildEntrypointName(Entrypoints::buildEntrypoint($component::getEntrypoint()));
        }
        $component = clone $component;
        if ($component->getEvent() && !$component->getEvent()->handler) {
            $component->getEvent()->handler = $this->handler;
        }
        $component->onRender(clone $this);
        if (!$component->getContent()) {
            $component->setContent($this->renderChildren($component));
        }
        return trim($this->renderTemplate($component));
    }

    protected function renderChildren(ViewComponent $component): string
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

    protected function renderList(ViewComponent $component): string
    {
        $result = '';
        foreach ($component->getModel()->getList() as $model) {
            $result .= trim($this->renderComponent($component->withModel($model)));
        }
        return $result;
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

    /**
     * @param string $handler
     * @return ViewRenderer
     */
    public function setHandler(string $handler): ViewRenderer
    {
        $this->handler = $handler;
        return $this;
    }


}