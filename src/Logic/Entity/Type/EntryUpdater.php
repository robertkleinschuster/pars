<?php

namespace Pars\Logic\Entity\Type;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

class EntryUpdater
{

    public function update()
    {
        $this->save((new Entry\Context())->setCode(Entity::CONTEXT_DEFINITION));
        $this->save((new Entry\Context())->setCode(Entity::CONTEXT_ENTRY));
        $this->save((new Entry\State())->setCode(Entity::STATE_ACTIVE));
        $this->save((new Entry\State())->setCode(Entity::STATE_INACTIVE));
        $this->save((new Entry\Group())->setCode(Entity::GROUP_SCHEMA));
        $this->save((new Entry\Group())->setCode(Entity::GROUP_SYSTEM));
        $this->save((new Entry\Group())->setCode(Entity::GROUP_CONTENT));

        $systemMenu = new Entry\Menu();
        $systemMenu->setCode('system');
        $systemMenu->setParameter([
            'type' => 'menu',
            'context' => 'entry',
            'group' => 'system'
        ]);
        $systemMenu = $this->save($systemMenu);

        $menuMenu = new Entry\Menu();
        $menuMenu->setParent($systemMenu->getId());
        $menuMenu->setCode('menu');
        $menuMenu->setParameter($systemMenu->getParameter());
        $this->save($menuMenu);

        $schemaMenu = new Entry\Menu();
        $schemaMenu->setParent($systemMenu->getId());
        $schemaMenu->setCode('schema');
        $schemaMenu->setParameter([
            'type' => 'type',
            'context' => 'definition',
            'group' => 'schema'
        ]);
        $this->save($schemaMenu);
    }


    public function save(Entity $entity)
    {
        $repo = new EntityRepository();
        $name = $entity->getName();
        $entity->setName('');

        if ($repo->exists($entity)) {
            $entity = $repo->find($entity)->current();
        } else {
            $entity->setName($name);
            $repo->save($entity);
        }

        return $entity;
    }

}