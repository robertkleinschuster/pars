<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\View\ViewComponent;

class OverviewFieldComponent extends ViewComponent
{
    protected string $key;
    protected string $name;

    public function __construct(string $key, string $name)
    {
        $this->key = $key;
        $this->name = $name;
        $this->setTemplate(__DIR__ . '/templates/overview_field.phtml');
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