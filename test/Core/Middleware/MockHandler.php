<?php

namespace ParsTest\Core\Middleware;

use HttpSoft\Message\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MockHandler implements RequestHandlerInterface
{
    public bool $handled = false;
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->handled = true;
        return (new ResponseFactory())->createResponse();
    }
}