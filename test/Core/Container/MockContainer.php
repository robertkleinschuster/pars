<?php

namespace ParsTest\Core\Container;

use Pars\Core\Container\Container;

class MockContainer extends Container
{
    public function set(string $service, $object): self
    {
        $this->services[$service] = $object;
        return $this;
    }
}