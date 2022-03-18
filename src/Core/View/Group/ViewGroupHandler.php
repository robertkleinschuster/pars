<?php

namespace Pars\Core\View\Group;

use Pars\Core\Http\{HtmlResponse, ServerRequest};
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
        if ($request instanceof ServerRequest) {
            $responseBody = '';
            $router = $request->getRequestRouter();
            $noRouteHandler = new NoRouteHandler();
            foreach ($this->requests as $routeRequest) {
                $routeResponse = $router->process($routeRequest, $noRouteHandler);
                $html = $routeResponse->getBody()->getContents();
                $responseBody .= $html;
            }

            $response = $response->withBody(create(StreamInterface::class, $responseBody));
        }
        return $response;
    }
}
