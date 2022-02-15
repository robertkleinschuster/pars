<?php

namespace Pars\Core\View\Icon;

use Pars\Core\View\ViewComponent;

class Icon extends ViewComponent
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/icon.phtml');
    }

    public function setIcon(string $icon)
    {
        $this->getModel()->set('icon', $icon);
        return $this;
    }

    public static function delete(): static
    {
        $icon = new static();
        $icon->setIcon('trash');
        return $icon;
    }

    public static function run()
    {
        $icon = new static();
        $icon->setIcon('play');
        return $icon;
    }

    public static function create() {
        $icon = new static();
        $icon->setIcon('plus-square');
        return $icon;
    }
}