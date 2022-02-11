<?php
namespace Pars\Core\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplStack;

class RequestRouter implements MiddlewareInterface
{
    protected SplStack $routes;

    public function __construct()
    {
        $this->routes = new SplStack();
    }

    public function route(string $route, RequestHandlerInterface $handler)
    {
        $this->routes->push(create(Route::class, $handler, $route));
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->routes as $route) {
            $matches = [];
            /* @var $route Route */
            if ($route->match($request->getUri()->getPath(), $matches)) {
                foreach ($matches as $key => $value) {
                    $request = $request->withAttribute($key, $value);
                }
                return $route->handler->handle($request);
            }
        }
        return $handler->handle($request);
    }

}

