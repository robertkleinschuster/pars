<?php

namespace Pars\Core\View\Input\Type;

class Button extends Text
{
    public function __toString(): string
    {
        return 'button';
    }
}
