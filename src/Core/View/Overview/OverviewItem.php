<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class OverviewItem extends ViewComponent
{
    protected function init()
    {
        parent::init();
        $this->addClass('overview__item');
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        foreach ($this->getChildren() as $child) {
            $child->model = $this->getModel();
        }
    }
}
