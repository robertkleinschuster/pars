<?php
namespace Pars\App\Admin\Menu;

use Pars\Core\View\ViewComponent;

class MenuComponent extends ViewComponent
{
    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/menu.phtml');
    }

}