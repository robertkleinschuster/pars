<?php
namespace Pars\Core\View;

class ViewRenderer
{
    protected ?ViewComponent $component = null;
    protected ViewModel $model;
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

    /**
     * @param ViewComponent $component
     * @return ViewRenderer
     */
    public function setComponent(ViewComponent $component): ViewRenderer
    {
        $this->component = $component;
        return $this;
    }


    protected function renderComponent(ViewComponent $component)
    {
        $result = '';
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

        if ($component->getTemplate()) {
            $this->content = $result;
            $this->initVariables($component);
            $result = $this->renderTemplate($component->getTemplate());
        }
        return $result;
    }

    protected function renderTemplate(string $template): string
    {
        ob_start();
        include $template;
        return ob_get_clean();
    }

    protected function initVariables(ViewComponent $component)
    {
        $this->attributes = "";
        $this->model = $component->getModel();
        if ($component->getEvent()) {
            $this->attributes .= " data-event=\"" . json_encode($component->getEvent()) . "\"";
        }
    }
}