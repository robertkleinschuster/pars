<?php
namespace Pars\Core\View\Navigation;

use Pars\Core\View\ViewComponent;

/**
 * @method NavigationModel getModel()
 */
class Navigation extends ViewComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/navigation.phtml');
        $this->model = new NavigationModel();
    }

    public function addEntry(string $name, string $link): NavigationModel
    {
        return $this->getModel()->addEntry($name, $link);
    }
}