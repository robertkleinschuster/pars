<?php

namespace Pars\Logic\Entity\Info;

use ArrayIterator;
use Pars\Core\Util\Json\JsonObject;
use Pars\Logic\Entity\Entity;

class EntityInfo extends JsonObject
{
    /**
     * @var EntityField[]|string[]|array[]|null[]
     */
    public array $fields = [];

    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class)
    {
        parent::__construct($array, $flags, $iteratorClass);
        foreach ($this->fields as $key => $field) {
            if (!isset($field) || is_scalar($field) || empty($key)) {
                unset($this->fields[$key]);
            } else {
                $fieldObj = new EntityField($field);
                if ($fieldObj->getNormalizedCode()) {
                    unset($this->fields[$key]);
                    $key = $fieldObj->getNormalizedCode();
                }
                if ($fieldObj->getCode()) {
                    $this->fields[$key] = $fieldObj;
                } else {
                    unset($this->fields[$key]);
                }
            }
        }
        if (!isset($this['fields'])) {
            $this['fields'] = &$this->fields;
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

    public function addOptionField(string $option, string $name = null)
    {
        $field = $this->getField('options') ?? new EntityField();
        $field->setScope(EntityField::SCOPE_ENTRY);
        $field->setCode('options');
        $field->setName(__('entity.options'));
        $field->getInput()->setType(EntityFieldInput::TYPE_MULTISELECT);
        $field->setFullwidth(true);
        $field->addOption($option, $name);
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
            $field->setScope(EntityField::SCOPE_ENTRY);
            $field->setCode("info[fields][$code][code]");
            $field->setName(__('entity.edit.field.code'));
            $field->setChapter(__('entity.edit.chapter.fields'));
            $field->setGroup($typeField->getName());
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setScope(EntityField::SCOPE_ENTRY);
            $field->setCode("info[fields][$code][name]");
            $field->setName(__('entity.edit.field.name'));
            $field->setChapter(__('entity.edit.chapter.fields'));
            $field->setGroup($typeField->getName());
            $fields[$field->getNormalizedCode()] = $field;

            if ($typeField->getViewOptions()->has('chapter')) {
                $field = new EntityField();
                $field->setCode("info[fields][$code][chapter]");
                $field->setName(__('entity.edit.field.chapter'));
                $field->setChapter(__('entity.edit.chapter.fields'));
                $field->setGroup($typeField->getName());
                $fields[$field->getNormalizedCode()] = $field;
            }

            if ($typeField->getViewOptions()->has('group')) {
                $field = new EntityField();
                $field->setCode("info[fields][$code][group]");
                $field->setName(__('entity.edit.field.group'));
                $field->setChapter(__('entity.edit.chapter.fields'));
                $field->setGroup($typeField->getName());
                $fields[$field->getNormalizedCode()] = $field;
            }

            if ($typeField->getViewOptions()->has('reference')) {
                $field = new EntityField();
                $field->setCode("info[fields][$code][reference][type]");
                $field->setName(__('entity.edit.field.reference_type'));
                $field->setChapter(__('entity.edit.chapter.fields'));
                $field->setGroup($typeField->getName());
                $field->getInput()->setType(EntityFieldInput::TYPE_SELECT);
                $field->getReference()->setType(Entity::TYPE_TYPE);
                $fields[$field->getNormalizedCode()] = $field;
            }

            $field = new EntityField();
            $field->setCode("info[fields][$code][input][type]");
            $field->setName(__('entity.edit.field.input_type'));
            $field->setChapter(__('entity.edit.chapter.fields'));
            $field->setGroup($typeField->getName());
            $field->getInput()->setType(EntityFieldInput::TYPE_SELECT);
            $field->setOptions([
                'text' => 'Text',
                'select' => 'Select',
                'editor' => 'Editor',
            ]);
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setScope(EntityField::SCOPE_ENTRY);
            $field->setCode("info[fields][$code][order]");
            $field->setName(__('entity.edit.field.order'));
            $field->setChapter(__('entity.edit.chapter.fields'));
            $field->setGroup($typeField->getName());
            $field->getInput()->setType(EntityFieldInput::TYPE_NUMBER);
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setScope(EntityField::SCOPE_ENTRY);
            $field->setCode("info[fields][$code][viewOptions]");
            $field->setName(__('entity.edit.field.viewOptions'));
            $field->setChapter(__('entity.edit.chapter.fields'));
            $field->setGroup($typeField->getName());
            $field->getInput()->setType(EntityFieldInput::TYPE_MULTISELECT);
            $field->setFullwidth(true);
            $field->setOptions([
                EntityField::VIEW_OPTION_OVERVIEW => 'Overview',
                EntityField::VIEW_OPTION_DETAIL => 'Detail',
                EntityField::VIEW_OPTION_GROUP => 'Group',
                EntityField::VIEW_OPTION_CHAPTER => 'Chapter',
                EntityField::VIEW_OPTION_REFERENCE => 'Reference',
            ]);
            $fields[$field->getNormalizedCode()] = $field;

            $field = new EntityField();
            $field->setScope(EntityField::SCOPE_ENTRY);
            $field->setCode("info[fields][$code]");
            $field->setName(__('entity.edit.button.delete_field'));
            $field->setIcon('trash');
            $field->setChapter(__('entity.edit.chapter.fields'));
            $field->getInput()->setType(EntityFieldInput::TYPE_BUTTON);
            $fields[$field->getNormalizedCode()] = $field;
        }

        $newFieldCode = $this->newFieldCode();
        $field = new EntityField();
        $field->setScope(EntityField::SCOPE_ENTRY);
        $field->setCode("info[fields][$newFieldCode][code]");
        $field->setName(__('entity.edit.button.add_field'));
        $field->getInput()->setType(EntityFieldInput::TYPE_BUTTON);
        $field->setIcon('plus');
        $field->setDefaultValue($newFieldCode);

        $fields[$field->getNormalizedCode()] = $field;


        return $fields;
    }

    protected function newFieldCode()
    {
        $newFieldCode = "new";
        $newFieldIndex = 1;
        while (isset($this->fields[$newFieldCode])) {
            $newFieldCode = "new-$newFieldIndex";
            $newFieldIndex++;
        }
        return $newFieldCode;
    }
}