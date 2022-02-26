<?php

namespace Pars\Core\View\Icon;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Icon extends ViewComponent implements EntrypointInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/icon.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Icon.ts';
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