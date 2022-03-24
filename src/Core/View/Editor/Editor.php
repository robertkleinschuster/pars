<?php

namespace Pars\Core\View\Editor;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Editor extends ViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/editor.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Editor.ts';
    }
}
