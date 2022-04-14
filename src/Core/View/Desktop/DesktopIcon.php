<?php

namespace Pars\Core\View\Desktop;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class DesktopIcon extends ViewComponent
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/desktop_icon.phtml');
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        $this->push((new Icon())->withModel($this->getModel()));
    }
}
