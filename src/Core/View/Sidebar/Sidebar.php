<?php

namespace Pars\Core\View\Sidebar;

use Pars\Core\View\{EntrypointInterface, ViewComponent};
use Psr\Http\Message\StreamInterface;

class Sidebar extends ViewComponent implements EntrypointInterface
{
    protected StreamInterface $sideContent;

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/sidebar.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Sidebar.ts';
    }

    public function getSideContent(): StreamInterface
    {
        return $this->sideContent;
    }

    /**
     * @param StreamInterface $sideContent
     * @return Sidebar
     */
    public function setSideContent(StreamInterface $sideContent): Sidebar
    {
        $this->sideContent = $sideContent;
        return $this;
    }
}
