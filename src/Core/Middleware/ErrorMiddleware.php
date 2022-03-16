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
    protected string $error = '';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        set_exception_handler([$this, 'exception']);
        set_error_handler([$this, 'error']);
        try {
            $response = $handler->handle($request);
        } catch (Throwable $exception) {
            $this->error = $exception->__toString();
            error_log($this->error);
            if (headers_sent()) {
                $this->render();
                exit;
            } else {
                return new Response(500, [], new ClosureStream($this->render(...)));
            }
        }
        return $response;
    }

    public function error()
    {
        $this->error = implode(', ', func_get_args());
        error_log($this->error);
        $this->render();
        exit;
    }

    public function exception(Throwable $throwable)
    {
        $this->error = $throwable->__toString();
        error_log($this->error);
        $this->render();
        exit;
    }

    public function render()
    {
        include 'templates/error.phtml';
    }
}
