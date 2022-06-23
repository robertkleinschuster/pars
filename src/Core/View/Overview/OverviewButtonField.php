<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;

class OverviewButtonField extends ViewComponent
{
    protected function init()
    {
        parent::init();
        $this->addClass('overview__buttons');
        $this->setTag('span');
    }

}