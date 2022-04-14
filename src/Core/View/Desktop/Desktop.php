<?php

namespace Pars\Core\View\Desktop;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class Desktop extends ViewComponent implements EntrypointInterface
{
    private DesktopIcon $icon;

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/desktop.phtml');
        $this->push($this->getIcon());
    }


    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Desktop.ts';
    }

    public function getIcon(): DesktopIcon
    {
        if (!isset($this->icon)) {
            $this->icon = new DesktopIcon();
        }
        return $this->icon;
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if (!$this->getIcon()->isList()) {
            $this->clearChildren();
        }
    }
}
