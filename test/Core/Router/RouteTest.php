<?php
namespace ParsTest\Core\Router;

use HttpSoft\Message\ServerRequest;
use HttpSoft\Message\Uri;
use Pars\Core\Router\Route;
use ParsTest\Core\Middleware\MockHandler;
use Psr\Http\Message\ServerRequestInterface;

class RouteTest extends \PHPUnit\Framework\TestCase
{
    public function testMatching()
    {
        $mockHandler = new MockHandler();
        $route = new Route($mockHandler, '/foo');
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo'));
        $result = $route->match($request);
        $this->assertInstanceOf(ServerRequestInterface::class, $result);
    }

    public function testMatchingWithPlaceholders()
    {
        $mockHandler = new MockHandler();
        $route = new Route($mockHandler, '/foo/:bar');
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo/asdf'));
        $result = $route->match($request);
        $this->assertInstanceOf(ServerRequestInterface::class, $result);
        $this->assertEquals('asdf', $result->getAttribute('bar'));
    }
}
