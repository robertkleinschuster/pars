<?php

namespace Pars\Core\View\Select;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;

class Select extends FormViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Select.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Select.ts';
    }

    public function addOption(string $key, string $label = ''): self
    {
        $option = new SelectOption();
        $option->setKey($key);
        $option->setId($key);
        $option->setLabel($label);
        $this->push($option);
        return $this;
    }
}
