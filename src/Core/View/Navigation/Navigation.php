<?php

namespace Pars\Core\View\Navigation;

use Pars\Core\View\{EntrypointInterface, Tree\Tree, ViewRenderer};

/**
 * @method NavigationModel getModel()
 * @property NavigationModel $model
 * @method NavigationItem getItem()
 */
class Navigation extends Tree implements EntrypointInterface
{
    protected bool $isParent = false;

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/navigation.phtml');
        $this->setItemClass(NavigationItem::class);
        $this->model = new NavigationModel();
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Navigation.ts';
    }


    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if ($this->getParent() instanceof NavigationItem) {
            $this->isParent = true;
        }
    }
}
