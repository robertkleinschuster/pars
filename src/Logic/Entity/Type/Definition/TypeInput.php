<?php

namespace Pars\Logic\Entity\Type\Definition;

use JsonSerializable;

class TypeInput implements JsonSerializable
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EDITOR = 'editor';
    public const TYPE_SELECT = 'select';

    private TypeField $field;

    private string $type = self::TYPE_TEXT;
    private bool $disabled = false;

    /**
     * @param TypeField $field
     */
    public function __construct(TypeField $field)
    {
        $this->field = $field;
    }

    /**
     * @return TypeField
     */
    public function getField(): TypeField
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
     * @return TypeInput
     */
    public function setType(string $type): TypeInput
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
     * @return TypeInput
     */
    public function setDisabled(bool $disabled): TypeInput
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
