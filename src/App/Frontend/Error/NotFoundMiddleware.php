<?php
namespace Pars\App\Frontend\Error;

use GuzzleHttp\Psr7\Response;
use JetBrains\PhpStorm\Pure;
use Pars\Core\Container\ContainerFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface, ContainerFactoryInterface
{
    #[Pure] public function create(array $params, string $id): static
    {
        return new static;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->heading = '404 - Seite nicht gefunden!';
        ob_start();
        require_once 'templates/error.phtml';
        $html = ob_get_clean();
        return new Response(404, [], $html);
    }

    public function __get(string $name)
    {
        return '';
    }

}