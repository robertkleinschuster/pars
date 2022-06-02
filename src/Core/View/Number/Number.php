<?php

namespace Pars\Core\View\Number;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\Input\Input;

class Number extends Input implements EntrypointInterface
{

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Number.phtml');
        $this->setType('number');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Number.ts';
    }
}
