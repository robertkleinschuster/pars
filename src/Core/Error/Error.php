<?php

namespace Pars\Core\Error;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Error extends ViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/error.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Error.ts';
    }
}
