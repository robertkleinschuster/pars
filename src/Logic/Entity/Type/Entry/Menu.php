<?php

namespace Pars\Logic\Entity\Type\Entry;

use Pars\Logic\Entity\Entity;

class Menu extends Entity
{
    public const DATA_PARAMS = 'params';

    public function getGroup(): string
    {
        return self::GROUP_SYSTEM;
    }

    public function getType(): string
    {
        return self::TYPE_MENU;
    }

    public function getContext(): string
    {
        return self::CONTEXT_ENTRY;
    }

    public function getDataParams(): array
    {
        return $this->getDataArray()[self::DATA_PARAMS] ?? [];
    }

    public function setDataParams(array $params): self
    {
        $this->replaceDataArray([self::DATA_PARAMS => $params]);
        return $this;
    }
}
