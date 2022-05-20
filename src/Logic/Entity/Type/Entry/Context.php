<?php

namespace Pars\Logic\Entity\Type\Entry;

use Pars\Logic\Entity\Entity;

class Context extends Entity
{
    public function getType(): string
    {
        return self::TYPE_CONTEXT;
    }
}
