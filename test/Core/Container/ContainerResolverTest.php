<?php

namespace ParsTest\Core\Container;

use Pars\Core\Container\ContainerResolver;
use Pars\Core\Container\DefaultFactory;
use Pars\Core\Emitter\SapiEmitter;
use ParsTest\Core\Emitter\MockSapiEmitter;
use PHPUnit\Framework\TestCase;

class ContainerResolverTest extends TestCase
{
    public function testShouldReturnDefaultFactoryWhenNoConfig()
    {
        $resolver = new MockContainerResolver(MockContainer::getInstance());
        $this->assertInstanceOf(DefaultFactory::class, $resolver->resolveFactory('foo'));
    }

    public function testShouldReturnCachedFactory()
    {
        $resolver = new MockContainerResolver(MockContainer::getInstance());
        $factory = $resolver->resolveFactory(SapiEmitter::class);
        $this->assertInstanceOf(MockSapiEmitter::class, $factory);
        $reflection = new \ReflectionClass(ContainerResolver::class);
        $property = $reflection->getProperty('factories');
        $cachedFactories = $property->getValue($resolver);
        $this->assertInstanceOf(MockSapiEmitter::class, $cachedFactories[SapiEmitter::class]);
    }

    public function testHasFactory()
    {
        $resolver = new MockContainerResolver(MockContainer::getInstance());
        $this->assertFalse($resolver->hasFactory('foo'));
        $this->assertTrue($resolver->hasFactory(SapiEmitter::class));
    }
}
