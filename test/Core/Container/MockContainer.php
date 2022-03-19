<?php

namespace ParsTest\Core\Container;

use Pars\Core\Container\Container;
use Pars\Core\Container\ContainerResolver;

class MockContainer extends Container
{
    public function set(string $service, $object): self
    {
        $this->services[$service] = $object;
        return $this;
    }

    protected function getResolver(): ContainerResolver
    {
        return new MockContainerResolver($this);
    }


}
