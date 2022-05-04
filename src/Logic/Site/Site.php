<?php

namespace Pars\Logic\Site;

use Pars\Logic\Entity\Entity;

class Site extends Entity
{
    protected function init()
    {
        parent::init();
        $this->setType('site');
        if (!$this->getState()) {
            $this->setState('active');
        }
    }
}
