<?php

namespace Pars\Logic\Entity\Info;

use Pars\Core\Util\Json\JsonObject;

class EntityFieldInput extends JsonObject
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EDITOR = 'editor';
    public const TYPE_SELECT = 'select';
    public const TYPE_CHECKBOX = 'checkbox';

    public string $type = self::TYPE_TEXT;
    public bool $disabled = false;

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
}
