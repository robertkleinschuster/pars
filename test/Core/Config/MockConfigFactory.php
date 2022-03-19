<?php

namespace ParsTest\Core\Config;

use Pars\Core\Container\ContainerFactoryInterface;

class MockConfigFactory implements ContainerFactoryInterface
{
    public function create(array $params, string $id): MockConfig
    {
        return new MockConfig(__DIR__ . '/examples/development');
    }
}