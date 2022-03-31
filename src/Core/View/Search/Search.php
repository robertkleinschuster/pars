<?php

namespace Pars\Core\View\Search;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Search extends ViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/search.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Search.ts';
    }
}
