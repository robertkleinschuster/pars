<?php

namespace ParsTest\Core\Middleware;

use HttpSoft\Message\Uri;
use HttpSoft\Message\UriFactory;
use HttpSoft\ServerRequest\ServerRequestCreator;
use Pars\Core\Pipeline\BasePath\BasePathMiddleware;
use Pars\Core\Url\UriBuilder;
use PHPUnit\Framework\TestCase;

class BasePathMiddlewareTest extends TestCase
{
    public function testShouldAddBasePathToUriBuilder()
    {
        $uriBuilder = new UriBuilder();
        $uriFactory = new UriFactory();
        $mockHandler = new MockHandler();
        $mockMiddleware = new MockMiddleware();
        $request = ServerRequestCreator::create()->withUri(new Uri('/test/foo'));
        $middleware = new BasePathMiddleware($uriBuilder, $uriFactory, $mockMiddleware, '/test');
        $middleware->process($request, $mockHandler);
        $this->assertTrue($mockMiddleware->processed);
        $this->assertEquals('/test', $uriBuilder);
    }
}
