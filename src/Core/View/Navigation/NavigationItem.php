<?php
namespace Pars\Core\View\Navigation;

use Pars\Core\View\Tree\TreeItem;
use Pars\Core\View\ViewRenderer;

/**
  * @method NavigationModel getModel()
 * @property NavigationModel $model
 */
class NavigationItem extends TreeItem
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/navigation_item.phtml');
        $this->setTreeClass(Navigation::class);
        $this->model = new NavigationModel();
    }
}