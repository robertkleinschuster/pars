<?php

namespace Pars\Core\Middleware;

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
                return response($this->render(), 500);
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
        ob_start();
        include 'templates/error.phtml';
        return ob_get_clean();
    }
}
