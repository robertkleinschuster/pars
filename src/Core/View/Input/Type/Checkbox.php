<?php

namespace Pars\Core\View\Input\Type;

use Pars\Core\View\Input\Input;

class Checkbox implements InputType
{
    public function __toString(): string
    {
        return 'checkbox';
    }

    public function attributes(Input $input, array $attributes): array
    {
        $attributes[] = "value='1'";
        if ($input->getValue($input->key)) {
            $attributes[] = 'checked';
        }
        return $attributes;
    }
}
