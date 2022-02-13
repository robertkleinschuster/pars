<?php

namespace Pars\Core\View;

class ViewRenderer
{
    protected ?ViewComponent $component = null;

    protected string $attributes = '';
    protected string $content = '';
    protected string $value = '';
    protected string $tag = 'div';

    public function render(): string
    {
        if (!$this->component) {
            throw new \Exception('No component set!');
        }
        return $this->renderComponent($this->component);
    }

    public function setComponent(ViewComponent $component): ViewRenderer
    {
        $this->component = $component;
        return $this;
    }

    protected function renderComponent(ViewComponent $component)
    {
        $result = '';
        if (!$component->getContent()) {
            if ($component->getModel()->isList()) {
                foreach ($component->getModel() as $model) {
                    $result .= $this->renderComponent($component->withModel($model));
                }
            } else {
                foreach ($component->getChildren() as $child) {
                    /* @var $child ViewComponent */
                    $result .= $this->renderComponent($child);
                }
            }
            $component->setContent($result);
        }

        if ($component->getTemplate()) {
            $result = $this->renderTemplate($component);
        }
        return $result;
    }

    protected function renderTemplate(ViewComponent $component)
    {
        return (function (ViewComponent $component) {
            ob_start();
            $model = $component->getModel();
            include $component->getTemplate();
            return ob_get_clean();
        })(...)->call($component, $component);
    }
}