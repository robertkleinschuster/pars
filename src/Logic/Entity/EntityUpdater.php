<?php

namespace Pars\Logic\Entity;

use Pars\Logic\Entity\Type\DefinitionUpdater;
use Pars\Logic\Entity\Type\EntryUpdater;

class EntityUpdater
{
    public function update()
    {
        (new DefinitionUpdater())->update();
        (new EntryUpdater())->update();
    }
}
