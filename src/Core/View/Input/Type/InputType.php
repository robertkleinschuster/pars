<?php

namespace Pars\Core\View\Input\Type;

use Pars\Core\View\Input\Input;

interface InputType
{
    public function __toString(): string;

    public function attributes(Input $input, array $attributes): array;
}
