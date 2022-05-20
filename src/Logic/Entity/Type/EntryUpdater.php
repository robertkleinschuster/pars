<?php

namespace Pars\Logic\Entity\Type;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

class EntryUpdater
{

    public function update()
    {
        $this->save((new Entry\State())->setCode(Entity::STATE_ACTIVE));
        $this->save((new Entry\State())->setCode(Entity::STATE_INACTIVE));

        $systemMenu = new Entry\Menu();
        $systemMenu->setCode('system');
        $systemMenu->setParameter([
            'type' => 'menu',
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