<?php
namespace Pars\App\Admin\Navigation;

use Pars\Core\View\ViewComponent;

/**
 * @method NavigationModel getModel()
 */
class NavigationComponent extends ViewComponent
{
    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/navigation.phtml');
        $this->model = new NavigationModel();
    }

    public function addEntry(string $name, string $link): NavigationModel
    {
        return $this->getModel()->addEntry($name, $link);
    }
}