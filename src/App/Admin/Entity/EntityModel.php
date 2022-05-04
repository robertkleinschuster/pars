<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\ViewModel;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Traversable;

class EntityModel extends ViewModel
{
    protected Entity $entity;
    
    /**
     * @return Entity
     */
    public function getEntity(): Entity
    {
        if (!isset($this->entity)) {
            $this->entity = new Entity();
        }
        return $this->entity;
    }
    
    /**
     * @param Entity $entity
     * @return EntityModel
     */
    public function setEntity(Entity $entity): EntityModel
    {
        $this->entity = $entity;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getEntity()->getId();
    }
    
    /**
     * @param string $id
     * @return EntityModel
     */
    public function setId(string $id): EntityModel
    {
        $this->getEntity()->setId($id);
        return $this;
    }
    
    public function getIterator(): Traversable
    {
        $repo = new EntityRepository();
        foreach ($repo->findByObject($this->getEntity()) as $entity) {
            yield (new static())->setEntity($entity);
        }
    }
    
    public function isList(): bool
    {
        return empty($this->getId());
    }
    
    public function get(string $name)
    {
        if ($name) {
            return $this->getEntityValue($name);
        }
        return parent::get($name);
    }
    
    public function getEntityValue(string $name)
    {
        return $this->getEntity()->{"get$name"}();
    }
    
}
