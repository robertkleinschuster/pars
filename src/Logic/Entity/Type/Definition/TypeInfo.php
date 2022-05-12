<?php

namespace Pars\Logic\Entity\Type\Definition;

use JsonSerializable;

class TypeInfo implements JsonSerializable
{
    /**
     * @var TypeField[]
     */
    private array $fields = [];

    public function addField(TypeField $field)
    {
        if ($field->getCode()) {
            $this->fields[$field->getNormalizedCode()] = $field;
        }
    }

    public function getField(string $code): ?TypeField
    {
        return $this->fields[TypeField::normalizeCode($code)] ?? null;
    }

    public function addTextField(string $code, string $name = null)
    {
        $field = $this->getField($code) ?? new TypeField();

        $field->setCode($code);
        if (!empty($name)) {
            $field->setName($name);
        }
        $field->getViewOptions()->enable(TypeField::VIEW_OPTION_DETAIL);
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
        $field = $this->getField($code) ?? new TypeField();
        $field->setCode($code);
        if (!empty($name)) {
            $field->setName($name);
        }
        $field->getReference()->setType($referenceType ?? $code);
        $field->getInput()->setType(TypeInput::TYPE_SELECT);
        $field->getViewOptions()->enable(TypeField::VIEW_OPTION_DETAIL);
        $this->addField($field);

        return $field;
    }

    /**
     * @return TypeField[]
     */
    public function getFields(): array
    {
        uasort($this->fields, function (TypeField $a, TypeField $b) {
            return $a->getOrder() - $b->getOrder();
        });
        return $this->fields;
    }

    public function from(array $data)
    {
        foreach ($data['fields'] ?? [] as $fieldData) {
            $field = new TypeField();
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