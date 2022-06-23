<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;

class OverviewButton extends ViewComponent
{
    public function init()
    {
        parent::init();
        $this->addClass('overview__button');
        $this->setTag('button');
    }

    public function getValue(string $key)
    {
        return $this->getParent()->getParent()->getModel()->get($key);
    }
}
