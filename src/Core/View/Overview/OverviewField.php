<?php
namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class OverviewField extends ViewComponent
{
    protected string $buttons = '';
    protected string $key;
    protected string $name;

    public function __construct(string $key, string $name)
    {
        parent::__construct();
        $this->key = $key;
        $this->name = $name;
        $this->setTemplate(__DIR__ . '/templates/overview_field.phtml');
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        $this->buttons = '';
        foreach ($this->getMain()->getButtons() as $button) {
            $button = $button->withModel($this->getParent()->getModel());
            $this->buttons .= $renderer->setComponent($button)->render();
        }
    }


    public function getContent(): string
    {
        return $this->getParent()->getModel()->get($this->key);
    }

    public function getValue(string $key)
    {
        return $this->getParent()->getModel()->get($key);
    }
}