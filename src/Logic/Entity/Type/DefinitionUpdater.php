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
        $this->save(new Definition\Group());
        $this->save(new Definition\Context());
        $this->save(new Definition\Menu());
    }

    public function save(Entity $entity)
    {
        $repo = new EntityRepository();
        $name = $entity->getName();
        $entity->setName('');

        if ($repo->exists($entity)) {
            $data = $entity->getData();
            $options = $entity->getOptions();
            $entity = $repo->find($entity, get_class($entity))->current();
            $entity->setData($data);
            $entity->setOptions($options);
        } else {
            $entity->setName($name);
        }

        return $repo->save($entity);
    }

}