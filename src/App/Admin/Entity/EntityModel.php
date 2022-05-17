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
    protected Type $type;

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
        $fields = $this->getType()->getInfo()->getFields();

        if ($this->getType()->isAllowEditFields()) {
            $fields = array_merge($fields, $this->getEntity()->getInfo()->getEditFields());
        }

        return $fields;
    }

    public function getType(): Type
    {
        if (!isset($this->type)) {
            if ($this->getEntity()->getType()) {
                $filterEntity = new Entity();
                $filterEntity->setType(Entity::TYPE_TYPE);
                $filterEntity->setCode($this->getEntity()->getType());
                $repo = new EntityRepository();
                $this->type = $repo->find($filterEntity, Type::class)->current() ?? new Type();
            } else {
                $this->type = new Type();
            }
        }
        return $this->type;
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
        if (strpos($name, 'type:') === 0) {
            return $this->getType()->find(substr($name, 5));
        }
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
