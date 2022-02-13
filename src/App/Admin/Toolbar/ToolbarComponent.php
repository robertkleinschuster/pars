<?php

namespace Pars\App\Admin\Toolbar;

use Pars\Core\View\ViewComponent;

class ToolbarComponent extends ViewComponent
{
    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/toolbar.phtml');
    }


    public function addButton(string $name): ToolbarButtonComponent
    {
        $button = create(ToolbarButtonComponent::class);
        $button->setContent($name);
        $this->push($button);
        return $button;
    }

}