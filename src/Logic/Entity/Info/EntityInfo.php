<?php

namespace Pars\Logic\Entity\Info;

use JsonSerializable;

class EntityInfo implements JsonSerializable
{
    /**
     * @var EntityField[]
     */
    private array $fields = [];

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

    public function from(array $data)
    {
        foreach ($data['fields'] ?? [] as $fieldData) {
            $field = new EntityField();
            if (is_array($fieldData)) {
                $this->addField($field->from($fieldData));
            }
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'fields' => $this->getFields()
        ];
    }
}