<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class OverviewHead extends ViewComponent
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/OverviewHead.phtml');
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        foreach ($this->getChildren() as $child) {
            $child->model = $this->getModel();
        }
        unset($this->model);
    }
}
