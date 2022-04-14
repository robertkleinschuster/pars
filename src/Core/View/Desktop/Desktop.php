<?php

namespace Pars\Core\View\Desktop;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\StreamInterface;

class Desktop extends ViewComponent implements EntrypointInterface
{
    private DesktopIcon $icon;
    protected ?StreamInterface $toolbar = null;

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/desktop.phtml');
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
        if ($this->getIcon()->isList()) {
            $this->push($this->getIcon());
        }
    }

    /**
     * @return StreamInterface|null
     */
    public function getToolbar(): ?StreamInterface
    {
        return $this->toolbar;
    }

    /**
     * @param StreamInterface|null $toolbar
     * @return Desktop
     */
    public function setToolbar(?StreamInterface $toolbar): Desktop
    {
        $this->toolbar = $toolbar;
        return $this;
    }

    public function setIconModel(ViewModel $model)
    {
        $this->icon = $this->getIcon()->withModel($model);
        return $this;
    }
}
