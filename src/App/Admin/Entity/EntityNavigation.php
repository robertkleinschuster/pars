<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Navigation\Navigation;
use Pars\Logic\Entity\EntityRepository;
use Pars\Logic\Entity\Type\Entry\Menu;

class EntityNavigation extends Navigation
{
    public function init()
    {
        parent::init();
        $repo = new EntityRepository();
        $rootMenus = [];
        foreach ($repo->find(new Menu(), Menu::class) as $menu) {
            $rootMenus[$menu->getId()] = $this->addEntry(
                $menu->getNameFallback(),
                url('/entity', $menu->getDataParams())
            );
        }

        foreach ($repo->findByParentIdList(array_keys($rootMenus), Menu::class) as $menu) {
            $rootMenus[$menu->getParent()]->addEntry(
                $menu->getNameFallback(),
                url('/entity', $menu->getDataParams())
            );
        }
    }
}
