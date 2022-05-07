<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Navigation\Navigation;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

class EntityNavigation extends Navigation
{
    public function init()
    {
        parent::init();
        $repo = new EntityRepository();
        $groupFilter = new Entity();
        $groupFilter->clear();
        $groupFilter->setType(Entity::TYPE_GROUP);
        foreach ($repo->find($groupFilter) as $group) {
            $groupMenu = $this->addEntry(
                $group->getNameFallback(),
                url('/entity', [
                    Entity::TYPE_TYPE => Entity::TYPE_TYPE,
                    Entity::TYPE_GROUP => $group->getCode(),
                    Entity::TYPE_CONTEXT => $group->getContext(),
                ])
            );

            $typeFilter = new Entity();
            $typeFilter->clear();
            $typeFilter->setType(Entity::TYPE_TYPE);
            $typeFilter->setGroup($group->getCode());
            foreach ($repo->find($typeFilter) as $type) {
                $groupMenu->addEntry(
                    $type->getNameFallback(),
                    url('/entity', [
                        Entity::TYPE_TYPE => $type->getCode(),
                        Entity::TYPE_CONTEXT => $type->getContext(),
                    ])
                );
            }
        }
    }
}
