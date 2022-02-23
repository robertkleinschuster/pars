<?php
namespace Pars\Core\View\Editor;

use Pars\Core\View\ViewComponent;

class Editor extends ViewComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/editor.phtml');
    }

}