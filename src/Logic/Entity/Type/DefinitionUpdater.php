<?php

namespace Pars\Logic\Entity\Type;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

class DefinitionUpdater
{
    public function update()
    {
        $this->save(new Definition\Type());
        $this->save(new Definition\State());
        $this->save(new Definition\Menu());
    }

    public function save(Entity $entity)
    {
        $repo = new EntityRepository();
        $name = $entity->getName();
        $entity->setName('');

        if (!$repo->exists($entity)) {
            $entity->setName($name);
            $repo->save($entity);
        }
    }

}