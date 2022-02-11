<?php
namespace Pars\Core\Http;

use Pars\Core\Container\ContainerFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequestFactory implements ContainerFactoryInterface
{
    public function create(array $params, string $id): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }

}