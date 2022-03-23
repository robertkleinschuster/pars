<?php

namespace Pars\Core\Error;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;
use Throwable;

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

    public static function fromException(Throwable $exception): Error
    {
        $error = new static();
        $error->getModel()->set('exception', $exception);
        $error->getModel()->set('code', $exception->getCode());
        $error->getModel()->set('message', $exception->getMessage());
        $error->getModel()->set('trace', $exception->getTraceAsString());
        return $error;
    }
}
