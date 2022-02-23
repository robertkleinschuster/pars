<?php

namespace Pars\Core\View\Navigation;

use Pars\Core\View\Tree\Tree;
use Pars\Core\View\ViewRenderer;

/**
 * @method NavigationModel getModel()
 * @property NavigationModel $model
 * @method NavigationItem getItem()
 */
class Navigation extends Tree
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/navigation.phtml');
        $this->setItemClass(NavigationItem::class);
        $this->model = create(NavigationModel::class);
    }

    public function onRender(ViewRenderer $renderer)
    {
        $this->getItem()->getModel()->setActive($this->getModel()->getActive());
        foreach ($this->getItem()->getModel()->getList() as $item) {
            $item->setActive($this->getModel()->getActive());
        }
        parent::onRender($renderer);
    }


}