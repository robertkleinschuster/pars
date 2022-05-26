<?php

namespace Pars\Core\View\Multiselect;

use Pars\Core\View\FormViewComponent;

class MultiselectOption extends FormViewComponent
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/MultiselectOption.phtml');
    }

    public function getInputName(): string
    {
        return "{$this->getParent()->key}[{$this->key}]";
    }

    public function getChecked(): string
    {
        $result = '';
        if ($this->getParentValue($this->getInputName())) {
            $result = 'checked';
        }
        return $result;
    }
}
