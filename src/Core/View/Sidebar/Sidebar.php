<?php

namespace Pars\Core\View\Sidebar;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Sidebar extends ViewComponent implements EntrypointInterface
{
    protected string $sideContent = '';

    public function init()
    {
        parent::init();
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

    /**
     * @param string $sideContent
     * @return Sidebar
     */
    public function setSideContent(string $sideContent): Sidebar
    {
        $this->sideContent = $sideContent;
        return $this;
    }
}
