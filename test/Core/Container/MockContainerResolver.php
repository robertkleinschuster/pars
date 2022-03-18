<?php

namespace ParsTest\Core\Container;

use Pars\Core\Container\ContainerConfig;
use Pars\Core\Container\ContainerResolver;

class MockContainerResolver extends ContainerResolver
{
    protected function getConfig(): ContainerConfig
    {
        return new MockContainerConfig();
    }
}