<?php

namespace ParsTest\Core\Pipeline\BasePath;

use HttpSoft\Message\Uri;
use HttpSoft\Message\UriFactory;
use HttpSoft\ServerRequest\ServerRequestCreator;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\Pipeline\BasePath\BasePathMiddleware;
use PHPUnit\Framework\TestCase;

class BasePathMiddlewareTest extends TestCase
{
    public function testShouldAddBasePathToUriBuilder()
    {
        $uriFactory = new UriFactory();
        $uriBuilder = new UriBuilder($uriFactory);
        $mockHandler = new MockHandler();
        $mockMiddleware = new MockMiddleware();
        $request = ServerRequestCreator::create()->withUri(new Uri('/test/foo'));
        $middleware = new BasePathMiddleware($uriBuilder, $uriFactory, $mockMiddleware, '/test');
        $middleware->process($request, $mockHandler);
        $this->assertTrue($mockMiddleware->processed);
        $this->assertEquals('/test', $uriBuilder);
    }
}
