<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\ViewModel;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\EntityRepository;
use Pars\Logic\Entity\Type\Definition\Type;
use Pars\Logic\Entity\Type\Definition\TypeField;
use Pars\Logic\Entity\Type\Definition\TypeInfo;
use Pars\Logic\Entity\Type\Definition\TypeInput;
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
     * @return TypeField[]
     */
    public function getFields(): array
    {
        $fields = $this->getEntityType()->getInfo()->getFields();

        if ($this->getEntityType()->isAllowEditFields()) {
            $info = new TypeInfo();
            $info->from($this->getEntity()->getDataArray()[Type::DATA_INFO] ?? []);
            foreach ($info->getFields() as $typeField) {
                $code = $typeField->getNormalizedCode();

                $field = new TypeField();
                $field->setCode("info[fields][$code][code]");
                $field->setName('Code');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][name]");
                $field->setName('Name');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][group]");
                $field->setName('Group');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][chapter]");
                $field->setName('Chapter');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][reference][type]");
                $field->setName('Reference Type');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $field->getInput()->setType(TypeInput::TYPE_SELECT);
                $field->getReference()->setType(Entity::TYPE_TYPE);
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][input][type]");
                $field->setName('Input Type');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $field->getInput()->setType(TypeInput::TYPE_SELECT);
                $field->setOptions([
                    'text' => 'Text',
                    'select' => 'Select',
                    'editor' => 'Editor',
                ]);
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][viewOptions][overview]");
                $field->setName('Show in overview');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $field->getInput()->setType(TypeInput::TYPE_CHECKBOX);
                $fields[$field->getNormalizedCode()] = $field;

                $field = new TypeField();
                $field->setCode("info[fields][$code][order]");
                $field->setName('Order');
                $field->setGroup($typeField->getName());
                $field->setChapter($typeField->getChapter());
                $fields[$field->getNormalizedCode()] = $field;
            }

            $field = new TypeField();
            $field->setCode('info[fields][][code]');
            $field->setName('Code');
            $field->setChapter('Add field');

            $fields[$field->getNormalizedCode()] = $field;
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
        return $this->getEntity()->findDataByFormKey($name);
    }


}
