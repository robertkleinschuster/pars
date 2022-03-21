<?php

namespace ParsTest\Core\Container;

use Pars\Core\Config\Config;
use Pars\Core\Container\ContainerConfig;
use Pars\Core\Http\Emitter\SapiEmitter;
use ParsTest\Core\Config\MockConfigFactory;
use ParsTest\Core\Http\Emitter\MockSapiEmitter;

class MockContainerConfig extends ContainerConfig
{
    public function getFactories(): array
    {
        $factories = parent::getFactories();
        $factories[SapiEmitter::class] = MockSapiEmitter::class;
        $factories[Config::class] = MockConfigFactory::class;
        return $factories;
    }
}
