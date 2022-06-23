<?php

namespace Pars\App\Admin\Entity;

use Generator;
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
        unset($this->type);
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
        if ($this->getType()->isAllowOwnFields()) {
            $fields = array_merge($fields, $this->getEntity()->getInfo()->getFields());
        }
        if ($this->getType()->isAllowEditFields()) {
            $fields = array_merge($fields, $this->getEntity()->getInfo()->getEditFields());
        }

        return $fields;
    }

    public function buildInputs(string $viewOption, bool $strictOption = false): Generator
    {
        foreach ($this->getFields() as $field) {
            if ((!empty($field->getCode()) && !$strictOption) || $field->getViewOptions()->has($viewOption)) {
                $builder = new EntityInputBuilder($this->getEntity(), $field);
                $input = $builder->build();
                if (null === $this->get($field->getCode()) || '' === $this->get($field->getCode())) {
                    $this->set($field->getCode(), $field->getDefaultValue());
                }
                yield $input->withModel($this)
                    ->setGroup($field->getGroup())
                    ->setChapter($field->getChapter());
            }
        }
    }

    public function getType(): Type
    {
        if (!isset($this->type)) {
            $repo = new EntityRepository();
            $this->type = $repo->findType($this->getEntity()->getType());
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
            return $this->getEntityValue($name) ?? parent::get($name);
        }
        return parent::get($name);
    }

    public function getEntityValue(string $name)
    {
        return $this->getEntity()->find($name);
    }


}
