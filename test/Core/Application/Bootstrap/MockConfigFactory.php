<?php

namespace ParsTest\Core\Application\Bootstrap;

use Pars\Core\Container\ContainerFactoryInterface;
use ParsTest\Core\Config\MockConfig;

class MockConfigFactory implements ContainerFactoryInterface
{
    public function create(string $id): MockConfig
    {
        return new MockConfig(__DIR__ . '/config');
    }
}
