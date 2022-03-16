<?php

namespace Pars\Core\View\Editor;

use Pars\Core\View\ViewComponent;

class Editor extends ViewComponent
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/editor.phtml');
    }
}
