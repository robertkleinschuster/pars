<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;

class OverviewField extends ViewComponent
{
    protected string $key = '';
    protected string $name = '';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/overview_field.phtml');
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
        if ($this->getValue($this->key)) {
            return $this->getValue($this->key);
        } else {
            return parent::getContent();
        }
    }

    public function getValue(string $key)
    {
        return $this->getParent()->getModel()->get($key);
    }
}