<?php

namespace Pars\Core\View\Group;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class ViewComponentGroup extends ViewComponent implements EntrypointInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->class[] = 'components';
    }


    public static function getEntrypoint(): string
    {
        return __DIR__ . '/ViewComponentGroup.ts';
    }

}