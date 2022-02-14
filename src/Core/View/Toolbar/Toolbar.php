<?php
namespace Pars\Core\View\Toolbar;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\ViewComponent;

class Toolbar extends ViewComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/toolbar.phtml');
    }


    public function addButton(string $name): ToolbarButton
    {
        $button = create(ToolbarButton::class);
        $button->setContent($name);
        $this->push($button);
        return $button;
    }

    public function addIconButton(Icon $icon): ToolbarButton
    {
        $button = create(ToolbarButton::class);
        $button->push($icon);
        $this->push($button);
        return $button;
    }
}