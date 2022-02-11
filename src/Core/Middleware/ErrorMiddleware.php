<?php

namespace Pars\Core\Middleware;

use GuzzleHttp\Psr7\Response;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ErrorMiddleware implements MiddlewareInterface
{
    protected array $errors = [];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Throwable $exception) {
            $this->error = $exception->__toString();
            error_log($this->error);
            return new Response(500, [], new ClosureStream($this->render(...)));
        }
        return $response;
    }

    public function render()
    {
        include 'templates/error.phtml';
    }
}