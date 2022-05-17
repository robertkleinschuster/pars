<?php

namespace Pars\Core\View\Input\Type;

use Pars\Core\View\Input\Input;

class Text implements InputType
{
    public function __toString(): string
    {
        return 'text';
    }

    public function attributes(Input $input, array $attributes): array
    {
        $attributes[] = "value='{$input->getValue($input->key)}'";
        return $attributes;
    }
}
