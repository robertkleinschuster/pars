<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\ViewModel;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\EntityRepository;
use Pars\Logic\Entity\Info\EntityField;
use Pars\Logic\Entity\Type\Definition\Type;
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
     * @throws EntityException
     */
    public function reloadEntity(): void
    {
        if (!empty($this->getId())) {
            $repo = new EntityRepository();
            $this->entity = $repo->findById($this->getId());
        } else {
            $this->entity = new Entity();
        }
    }

    /**
     * @return EntityField[]
     */
    public function getFields(): array
    {
        $fields = $this->getEntityType()->getInfo()->getFields();
     
        if ($this->getEntityType()->isAllowEditFields()) {
            $fields = array_merge($fields, $this->getEntity()->getInfo()->getEditFields());
        }

        return $fields;
    }

    public function getEntityType(): Type
    {
        $entity = $this->getEntity();
        $repo = new EntityRepository();

        $filterEntity = new Entity();
        $filterEntity->setType(Entity::TYPE_TYPE);
        $filterEntity->setCode($entity->getType());
        return $repo->find($filterEntity, Type::class)->current();
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
     * @throws EntityException
     */
    public function setId(string $id): EntityModel
    {
        $this->getEntity()->setId($id);
        $this->reloadEntity();
        return $this;
    }

    public function getIterator(): Traversable
    {
        $repo = new EntityRepository();
        foreach ($repo->find($this->getEntity()) as $entity) {
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
        return $this->getEntity()->find($name);
    }


}
