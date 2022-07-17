<?php

namespace ParsTest\Core\Application\Base;

use HttpSoft\Message\Response;
use Pars\Core\Application\AbstractApplication;
use Pars\Core\Container\Container;
use Pars\Core\Http\Emitter\SapiEmitter;
use ParsTest\Core\Http\Emitter\MockSapiEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractApplicationTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldProcessPipeline()
    {
        $application = $this->getMockBuilder(AbstractApplication::class)
            ->getMockForAbstractClass();

        $middleware = new class implements MiddlewareInterface {
            public bool $processed = false;
            public function process(
                ServerRequestInterface $request,
                RequestHandlerInterface $handler
            ): ResponseInterface {
                $this->processed = true;
                return new Response(200);
            }
        };

        $application->pipe($middleware);
        $application->run();
        $this->assertTrue($middleware->processed);
    }


    public function testShouldProcessPipelineInOrder()
    {
        $application = $this->getMockBuilder(AbstractApplication::class)
            ->getMockForAbstractClass();
        $application->pipe(new MiddlewareOrderTracker('first'));
        $application->pipe(new MiddlewareOrderTracker('second'));
        $application->run();
        $this->assertEquals('first', MiddlewareOrderTracker::$middlewares[0]);
        $this->assertEquals('second', MiddlewareOrderTracker::$middlewares[1]);
    }


    public function testShouldReturnNotFoundByDefault()
    {
        $application = $this->getMockBuilder(AbstractApplication::class)
            ->getMockForAbstractClass();
        $application->run();
        /* @var MockSapiEmitter $emitter */
        $emitter = Container::getInstance()->get(SapiEmitter::class);
        $this->assertEquals(404, $emitter->getResponse()->getStatusCode());
    }
}
