<?php

namespace Pars\Logic\Entity\Info;

use JsonSerializable;

class EntityFieldInput implements JsonSerializable
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EDITOR = 'editor';
    public const TYPE_SELECT = 'select';
    public const TYPE_CHECKBOX = 'checkbox';

    private EntityField $field;

    private string $type = self::TYPE_TEXT;
    private bool $disabled = false;

    /**
     * @param EntityField $field
     */
    public function __construct(EntityField $field)
    {
        $this->field = $field;
    }

    /**
     * @return EntityField
     */
    public function getField(): EntityField
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return EntityFieldInput
     */
    public function setType(string $type): EntityFieldInput
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return EntityFieldInput
     */
    public function setDisabled(bool $disabled): EntityFieldInput
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'disabled' => $this->isDisabled(),
        ];
    }

    public function from(array $data): self
    {
        if (isset($data['type'])) {
            $this->setType($data['type']);
        }
        $this->setDisabled($data['disabled'] ?? $this->isDisabled());
        return $this;
    }
}
