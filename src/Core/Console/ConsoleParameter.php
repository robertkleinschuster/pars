<?php

namespace Pars\Core\Console;

class ConsoleParameter
{
    protected array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function has(string $name)
    {
        return in_array($name, $this->data);
    }
}
