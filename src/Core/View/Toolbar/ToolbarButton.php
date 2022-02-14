<?php
namespace Pars\Core\View\Toolbar;

use Pars\Core\View\ViewComponent;

class ToolbarButton extends ViewComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/toolbar_button.phtml');
    }
}