<?php

namespace Pars\Core\View\Input\Type;


class Number extends Text
{
    public function __toString(): string
    {
        return 'number';
    }
}
