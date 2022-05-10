<?php

namespace Pars\Logic\Entity\Type\Entry;

use Pars\Logic\Entity\Entity;

class Context extends Entity
{
    public function getGroup(): string
    {
        return self::GROUP_SYSTEM;
    }

    public function getType(): string
    {
        return self::TYPE_CONTEXT;
    }

    public function getContext(): string
    {
        return self::CONTEXT_ENTRY;
    }
}
