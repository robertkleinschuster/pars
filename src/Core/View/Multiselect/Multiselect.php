<?php

namespace Pars\Core\View\Multiselect;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;

class Multiselect extends FormViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Multiselect.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Multiselect.ts';
    }

    public function addValue(string $key, string $label = null): self
    {
        $option = new MultiselectOption();
        $option->setLabel($label);
        $option->setKey($key);
        $option->setId($key);
        $this->push($option);

        return $this;
    }
}
