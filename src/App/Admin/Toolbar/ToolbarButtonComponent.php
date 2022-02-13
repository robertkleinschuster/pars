<?php
namespace Pars\App\Admin\Toolbar;

use Pars\Core\View\ViewComponent;

class ToolbarButtonComponent extends ViewComponent
{
    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/toolbar_button.phtml');
    }

}