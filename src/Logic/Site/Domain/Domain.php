<?php

namespace Pars\Logic\Site\Domain;

use Pars\Logic\Entity\Entity;

class Domain extends Entity
{
    protected function init()
    {
        parent::init();
        $this->setType('domain');
        if (!$this->getState()) {
            $this->setState('active');
        }
    }
}
