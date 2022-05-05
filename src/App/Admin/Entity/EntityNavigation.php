<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Navigation\Navigation;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

class EntityNavigation extends Navigation
{
    public function addType(string $type = Entity::TYPE_DATA, string $context = Entity::CONTEXT_DATA)
    {
        $repo = new EntityRepository();
        $submenu = $this->addEntry(
            __("admin.navigation.entity.$type"),
            url('/entity', [Entity::TYPE_CONTEXT => $context])
        );
        $filterEntity = new Entity();
        $filterEntity->clear();
        $filterEntity->setContext(Entity::CONTEXT_DEFINITION);
        $filterEntity->setType($type);
        foreach ($repo->find($filterEntity) as $entity) {
            /** @var Entity $entity */
            $submenu->addEntry(
                __("admin.navigation.entity.$type.{$entity->getCode()}"),
                url('/entity', ['type' => $entity->getCode(), 'context' => $context])
            );
        }
    }
}