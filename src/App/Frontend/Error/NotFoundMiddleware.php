<?php

namespace Pars\App\Frontend\Error;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\Http\ClosureResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface, ContainerFactoryInterface
{
    protected string $heading;

    final public function __construct()
    {
    }


    public function create(array $params, string $id): static
    {
        return new static();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->heading = '404 - Seite nicht gefunden!';

        return create(ClosureResponse::class, $this->render(...), 404);
    }

    public function __get(string $name)
    {
        return '';
    }

    protected function render()
    {
        ob_start();
        include 'templates/error.phtml';
        return ob_get_clean();
    }
}
