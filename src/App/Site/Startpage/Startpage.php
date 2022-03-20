<?php

namespace Pars\App\Site\Startpage;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Startpage extends ViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/startpage.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Startpage.ts';
    }
}
