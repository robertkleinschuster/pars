<?php

namespace Pars\Core\Error\NotFound;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class NotFound extends ViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/notfound.phtml');
    }


    public static function getEntrypoint(): string
    {
        return __DIR__ . '/NotFound.ts';
    }
}
