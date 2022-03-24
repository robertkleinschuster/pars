<?php

namespace Pars\Core\View\Group;

use Pars\Core\Http\Stream\QueueStream;
use Pars\Core\Router\RequestRouter;
use Psr\Http\Message\{ResponseFactoryInterface, ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class ViewGroupHandler implements RequestHandlerInterface
{
    protected SplQueue $requests;
    protected ResponseFactoryInterface $responseFactory;

    public function __construct()
    {
        $this->responseFactory = get(ResponseFactoryInterface::class);
        $this->requests = new SplQueue();
    }


    /**
     * @param ServerRequestInterface $request
     * @param string|null $path
     * @return $this
     */
    public function push(ServerRequestInterface $request, string $path = null): self
    {
        if ($path) {
            $request = $request->withUri($request->getUri()->withPath($path));
        }
        $this->requests->push($request);
        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queueStream = new QueueStream();
        $response = $this->responseFactory->createResponse();
        $router = $request->getAttribute(RequestRouter::class);
        if ($router instanceof RequestRouter) {
            $noRouteHandler = new NoRouteHandler();
            foreach ($this->requests as $routeRequest) {
                $routeResponse = $router->process($routeRequest, $noRouteHandler);
                $queueStream->push($routeResponse->getBody());
            }
        }
        return $response->withBody($queueStream);
    }
}
