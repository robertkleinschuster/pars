<?php

namespace Pars\Core\View\Button;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;

class Button extends FormViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Button.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Button.ts';
    }

    protected function attr(): string
    {
        $result = parent::attr();
        $attributes[] = "name='$this->key'";
        $attributes[] = "value='{$this->getValue($this->key)}'";
        return $result . ' ' . implode(' ', $attributes);
    }
}
