<?php
namespace Pars\Core\View\Group;

use Pars\Core\Http\HtmlResponse;
use Pars\Core\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class ViewGroupHandler implements RequestHandlerInterface
{

    protected SplQueue $requests;

    public function __construct()
    {
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
        $response =  create(HtmlResponse::class);
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