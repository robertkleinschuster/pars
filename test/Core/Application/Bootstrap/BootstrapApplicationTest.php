<?php

namespace ParsTest\Core\Application\Bootstrap;

use Pars\Core\Application\Bootstrap\BootstrapApplication;
use Pars\Core\Config\Config;
use ParsTest\Core\Application\Base\MiddlewareOrderTracker;
use ParsTest\Core\Container\MockContainer;

class BootstrapApplicationTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $container = MockContainer::getInstance();
        $container->getResolver()->overrideFactory(Config::class, MockConfigFactory::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $container = MockContainer::getInstance();
        $container->getResolver()->overrideFactory(Config::class, \ParsTest\Core\Config\MockConfigFactory::class);
    }


    public function testShouldPipeAppsFromConfig()
    {
        $container = MockContainer::getInstance();
        $request = http()->createServerRequest();

        $application = new BootstrapApplication();
        $application->handle($request->withUri($request->getUri()->withPath('/first')));

        /* @var MockFirstWebApplication $first */
        $first = $container->get(MockFirstWebApplication::class);
        /* @var MockSecondWebApplication $second */
        $second = $container->get(MockSecondWebApplication::class);
        /* @var MockSecondWebApplication $third */
        $third = $container->get(MockThirdWebApplication::class);

        $this->assertTrue($first->handled);
        $this->assertFalse($second->handled);
        $this->assertFalse($third->handled);

        $this->assertCount(1, MiddlewareOrderTracker::$middlewares);
        $this->assertEquals('first', MiddlewareOrderTracker::$middlewares[0]);
    }
}