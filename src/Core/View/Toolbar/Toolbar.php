<?php

namespace Pars\Core\View\Toolbar;

use Pars\Core\View\{EntrypointInterface, Icon\Icon, ViewComponent};

class Toolbar extends ViewComponent implements EntrypointInterface
{
    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/toolbar.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Toolbar.ts';
    }

    public function addButton(string $name): ToolbarButton
    {
        $button = new ToolbarButton();
        $button->setContent($name);
        $this->push($button);
        return $button;
    }

    public function addIconButton(Icon $icon): ToolbarButton
    {
        $button = new ToolbarButton();
        $button->push($icon);
        $this->push($button);
        return $button;
    }
}
