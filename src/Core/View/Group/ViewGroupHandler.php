<?php

namespace Pars\Core\View\Group;

use Pars\Core\Router\RequestRouter;
use Psr\Http\Message\{ResponseFactoryInterface, ResponseInterface, ServerRequestInterface, StreamInterface};
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class ViewGroupHandler implements RequestHandlerInterface
{
    protected SplQueue $requests;
    protected ResponseFactoryInterface $responseFactory;

    public function __construct()
    {
        $this->responseFactory = create(ResponseFactoryInterface::class);
        $this->requests = new SplQueue();
    }


    /**
     * @param ServerRequestInterface $request
     * @return $this
     */
    public function push(ServerRequestInterface $request): self
    {
        $this->requests->push($request);
        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();
        $responseBody = '';
        $router = $request->getAttribute(RequestRouter::class);
        if ($router instanceof RequestRouter) {
            $noRouteHandler = new NoRouteHandler();
            foreach ($this->requests as $routeRequest) {
                $routeResponse = $router->process($routeRequest, $noRouteHandler);
                $responseBody .= $routeResponse->getBody()->getContents();
            }
        }
        return $response->withBody(http()->streamFactory()->createStream($responseBody));
    }
}
