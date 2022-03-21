<?php

namespace ParsTest\Core\Container;

use Pars\Core\Application\ApplicationContainer;
use Pars\Core\Container\ContainerResolver;

/**
 * @method static $this getInstance()
 */
class MockContainer extends ApplicationContainer
{
    public function set(string $service, $object): self
    {
        $this->services[$service] = $object;
        return $this;
    }

    public function getResolver(): ContainerResolver
    {
        return parent::getResolver();
    }
}
