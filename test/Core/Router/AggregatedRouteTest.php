<?php

namespace ParsTest\Core\Router;

use HttpSoft\Message\ServerRequest;
use HttpSoft\Message\Uri;
use Pars\Core\Router\AggregatedRoute;
use ParsTest\Core\Pipeline\BasePath\MockHandler;
use PHPUnit\Framework\TestCase;

class AggregatedRouteTest extends TestCase
{
    public function testMatchingAny()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo'));
        $route->match($request);
        $this->assertTrue($route->isMatched());
    }

    public function testMatchingPath()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $route->pattern('/foo');
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo'));
        $route->match($request);
        $this->assertTrue($route->isMatched());
    }

    public function testNotMatchingPath()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $route->pattern('/bar');
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo'));
        $route->match($request);
        $this->assertFalse($route->isMatched());
    }

    public function testMatchingWithPlaceholders()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $route->pattern('/foo/:bar');
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo/asdf'));
        $route->match($request);
        $this->assertTrue($route->isMatched());
        $this->assertEquals('asdf', $route->getMatchedRequest()->getAttribute('bar'));
    }

    public function testMatchingWithPlaceholdersContinuous()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $route->pattern('/foo/b/:bar+');

        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo/b/asdf/123/123'));
        $route->match($request);
        $this->assertTrue($route->isMatched());
        $this->assertEquals('asdf/123/123', $route->getMatchedRequest()->getAttribute('bar'));
    }

    public function testMatchingMethod()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo'));
        $request = $request->withMethod('POST');
        $route->match($request);
        $route->method('POST');
        $this->assertTrue($route->isMatched());
    }

    public function testNotMatchingMethod()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/foo'));
        $request = $request->withMethod('GET');
        $route->method('POST');
        $route->match($request);
        $this->assertFalse($route->isMatched());
    }

    public function testMatchingHeader()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $request = new ServerRequest();
        $request = $request->withHeader('x-test', 'the-test-value');
        $route->header('x-test', 'the-test-value');
        $route->match($request);
        $this->assertTrue($route->isMatched());
    }

    public function testNotMatchingHeader()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $request = new ServerRequest();
        $request = $request->withHeader('x-test', 'the-test-value');
        $route->header('x-test', '');
        $route->match($request);
        $this->assertFalse($route->isMatched());
    }


    public function testExtendingRoute()
    {
        $mockHandler = new MockHandler();
        $route = new AggregatedRoute($mockHandler);
        $route->pattern('/test');
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('/test'));
        $route->match($request);

        $this->assertTrue($route->isMatched());


        $extendedMockHandler = new MockHandler();


        $request = new ServerRequest();
        $request = $request->withHeader('x-test', 'the-test-value');
        $route->header('x-test', 'the-test-value');
        $route->match($request);
    }
}
