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

    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return OverviewField
     */
    public function setKey(string $key): OverviewField
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return OverviewField
     */
    public function setName(string $name): OverviewField
    {
        $this->name = $name;
        return $this;
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