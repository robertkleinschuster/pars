<?php

namespace Pars\Logic\Entity\Type\Entry;

use Pars\Logic\Entity\Entity;

class Menu extends Entity
{
    public const DATA_PARAMETER = 'params';

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

    public function getParameter()
    {
        return $this->getDataObject()->find(self::DATA_PARAMETER, []);
    }

    public function setParameter(array $parameter): self
    {
        $this->getDataObject()->fromArray([self::DATA_PARAMETER => $parameter]);
        return $this;
    }
}
