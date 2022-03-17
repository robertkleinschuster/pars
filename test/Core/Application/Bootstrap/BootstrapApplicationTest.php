<?php

namespace ParsTest\Core\Application\Bootstrap;

use Pars\Core\Application\Bootstrap\BootstrapApplication;
use Pars\Core\Config\Config;
use Pars\Core\Http\ServerRequest;
use ParsTest\Core\Config\MockConfig;
use ParsTest\Core\Container\MockContainer;

class BootstrapApplicationTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldPipeAppsFromConfigFirst()
    {
        $container = MockContainer::getInstance();
        /* @var MockConfig $config */
        $config = $container->get(Config::class);
        $config->set('apps', [
            '/first' => MockFirstWebApplication::class,
            '/second' => MockSecondWebApplication::class,
        ]);
        /* @var ServerRequest $request */
        $request = $container->get(ServerRequest::class);
        $request = $request->withUri($request->getUri()->withPath('/first'));
        $container->set(ServerRequest::class, $request);
        $application = new BootstrapApplication();
        $application->run();

        /* @var MockFirstWebApplication $first */
        $first = $container->get(MockFirstWebApplication::class);
        /* @var MockSecondWebApplication $second */
        $second = $container->get(MockSecondWebApplication::class);
        $this->assertTrue($first->handled);
        $this->assertFalse($second->handled);
    }

    public function testShouldPipeAppsFromConfigSecond()
    {
        $container = MockContainer::getInstance();
        /* @var MockConfig $config */
        $config = $container->get(Config::class);
        $config->set('apps', [
            '/first' => MockFirstWebApplication::class,
            '/second' => MockSecondWebApplication::class,
        ]);
        /* @var ServerRequest $request */
        $request = $container->get(ServerRequest::class);
        $request = $request->withUri($request->getUri()->withPath('/second'));
        $container->set(ServerRequest::class, $request);
        $application = new BootstrapApplication();
        $application->run();

        /* @var MockFirstWebApplication $first */
        $first = $container->get(MockFirstWebApplication::class);
        /* @var MockSecondWebApplication $second */
        $second = $container->get(MockSecondWebApplication::class);
        $this->assertFalse($first->handled);
        $this->assertTrue($second->handled);
    }
}