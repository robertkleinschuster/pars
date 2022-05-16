<?php

namespace Pars\Logic\Entity\Info;

use ArrayIterator;
use Pars\Core\Util\Json\JsonObject;
use Pars\Logic\Entity\Entity;

class EntityInfo extends JsonObject
{
    /**
     * @var EntityField[]
     */
    public array $fields = [];

    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class)
    {
        parent::__construct($array, $flags, $iteratorClass);
        foreach ($this->fields as $key => $field) {
            $this->fields[$key] = new EntityField($field);
        }
    }


    public function addField(EntityField $field)
    {
        if ($field->getCode()) {
            $this->fields[$field->getNormalizedCode()] = $field;
        }
    }

    public function getField(string $code): ?EntityField
    {
        return $this->fields[EntityField::normalizeCode($code)] ?? null;
    }

    public function addTextField(string $code, string $name = null)
    {
        $field = $this->getField($code) ?? new EntityField();

        $field->setCode($code);
        if (!empty($name)) {
            $field->setName($name);
        }
        $field->getViewOptions()->enable(EntityField::VIEW_OPTION_DETAIL);
        $this->addField($field);

        return $field;
    }

    public function addCheckboxField(string $code, string $name = null)
    {
        $field = $this->getField($code) ?? new EntityField();

        $field->setCode($code);
        if (!empty($name)) {
            $field->setName($name);
        }
        $field->getInput()->setType(EntityFieldInput::TYPE_CHECKBOX);
        $field->getViewOptions()->enable(EntityField::VIEW_OPTION_DETAIL);
        $this->addField($field);

        return $field;
    }

    public function addDisabledField(string $code, string $name = null)
    {
        $field = $this->addTextField($code, $name);
        $field->getInput()->setDisabled(true);
        return $field;
    }

    public function addSelectField(string $code, string $name = null, string $referenceType = null)
    {
        $field = $this->getField($code) ?? new EntityField();
        $field->setCode($code);
        if (!empty($name)) {
            $field->setName($name);
        }
        $field->getReference()->setType($referenceType ?? $code);
        $field->getInput()->setType(EntityFieldInput::TYPE_SELECT);
        $field->getViewOptions()->enable(EntityField::VIEW_OPTION_DETAIL);
        $this->addField($field);

        return $field;
    }

    /**
     * @return EntityField[]
     */
    public function getFields(): array
    {
        uasort($this->fields, function (EntityField $a, EntityField $b) {
            return $a->getOrder() - $b->getOrder();
        });
        return $this->fields;
    }

    public function getEditFields(): array
    {
        $fields = [];
        foreach ($this->getFields() as $typeField) {
            $code = $typeField->getNormalizedCode();

            $field = new EntityField();
            $field->setCode("info[fields][$code][code]");
            $field->setName('Code');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][name]");
            $field->setName('Name');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][group]");
            $field->setName('Group');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][chapter]");
            $field->setName('Chapter');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][reference][type]");
            $field->setName('Reference Type');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $field->getInput()->setType(EntityFieldInput::TYPE_SELECT);
            $field->getReference()->setType(Entity::TYPE_TYPE);
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][input][type]");
            $field->setName('Input Type');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $field->getInput()->setType(EntityFieldInput::TYPE_SELECT);
            $field->setOptions([
                'text' => 'Text',
                'select' => 'Select',
                'editor' => 'Editor',
            ]);
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][viewOptions][overview]");
            $field->setName('Show in overview');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $field->getInput()->setType(EntityFieldInput::TYPE_CHECKBOX);
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setCode("info[fields][$code][order]");
            $field->setName('Order');
            $field->setGroup($typeField->getName());
            $field->setChapter($typeField->getChapter());
            $fields[$field->getNormalizedCode()] = $field;
        }

        $field = new EntityField();
        $field->setCode('info[fields][][code]');
        $field->setName('Code');
        $field->setChapter('Add field');

        $fields[$field->getNormalizedCode()] = $field;

        return $fields;
    }
}