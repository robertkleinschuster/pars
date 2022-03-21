<?php

namespace ParsTest\Core\Pipeline;

use HttpSoft\Message\ServerRequest;
use Pars\Core\Pipeline\MiddlewarePipeline;
use ParsTest\Core\Pipeline\BasePath\MockHandler;
use ParsTest\Core\Pipeline\BasePath\MockMiddleware;

class MiddlewarePipelineTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldExecuteHandler()
    {
        $mockHandler = new MockHandler();
        $pipeline = new MiddlewarePipeline($mockHandler);
        $pipeline->handle(new ServerRequest());
        $this->assertTrue($mockHandler->handled);
    }

    public function testShouldProcessMiddleware()
    {
        $mockHandler = new MockHandler();
        $mockMiddleware = new MockMiddleware();
        $pipeline = new MiddlewarePipeline($mockHandler);
        $pipeline = $pipeline->with($mockMiddleware);
        $pipeline->handle(new ServerRequest());
        $this->assertTrue($mockMiddleware->processed);
        $this->assertTrue($mockHandler->handled);
    }
}