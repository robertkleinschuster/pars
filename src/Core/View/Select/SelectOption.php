<?php

namespace Pars\Core\View\Select;

use Pars\Core\View\FormViewComponent;

/**
 * @method Select getParent()
 */
class SelectOption extends FormViewComponent
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/SelectOption.phtml');
    }

    public function getSelected(): string
    {
        $result = '';

        if ($this->getParentValue($this->getParent()->key) === $this->key) {
            $result = ' selected';
        }
        return $result;
    }
}