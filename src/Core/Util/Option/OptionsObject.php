<?php

namespace Pars\Core\Util\Option;

use ArrayIterator;
use Pars\Core\Util\Json\JsonObject;

class OptionsObject extends JsonObject
{
    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class)
    {
        parent::__construct($array, $flags, $iteratorClass);
        foreach ($this as &$option) {
            $option = (bool) $option;
        }
    }


    public function has(string $option): bool
    {
        return isset($this[$option]) && true === $this[$option];
    }

    public function set(string $option, bool $value): self
    {
        $this[$option] = $value;
        return $this;
    }

    public function enable(string $option): self
    {
        return $this->set($option, true);
    }

    public function disable(string $option): self
    {
        return $this->set($option, false);
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        parent::offsetSet($key, (bool) $value);
    }
}
