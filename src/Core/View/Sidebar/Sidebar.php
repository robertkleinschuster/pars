<?php

namespace Pars\Core\View\Sidebar;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class Sidebar extends ViewComponent implements EntrypointInterface
{
    protected ?ViewComponent $side = null;
    protected string $sideContent = '';

    public function __construct(ViewComponent $side = null)
    {
        parent::__construct();
        $this->side = $side;
        $this->setTemplate(__DIR__ . '/templates/sidebar.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Sidebar.ts';
    }

    public function getSideContent(): string
    {
        return $this->sideContent;
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if ($this->side) {
            $this->sideContent = $renderer->setComponent($this->side)->render();
        }
    }
}