<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\Input\Input;
use Pars\Core\View\Number\Number;

class NumberBuilder extends TextBuilder
{
    protected function createInput(): Input
    {
        return new Number();
    }
}
