<?php

namespace Pars\Core\View\Navigation;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\ViewRenderer;

/**
 * @method NavigationModel getModel()
 * @property NavigationModel $model
 * @method NavigationItem getItem()
 */
class Navigation extends Tree implements EntrypointInterface
{
    protected bool $isParent = false;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/navigation.phtml');
        $this->setItemClass(NavigationItem::class);
        $this->model = create(NavigationModel::class);
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/NavigationComponent.ts';
    }


    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if ($this->getParent() instanceof NavigationItem) {
            $this->isParent = true;
        }
    }


}