<?php

namespace Pars\Core\View;

use Pars\Core\Http\HtmlResponse;
use Pars\Core\Http\NotFoundResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplStack;

class ViewComponentHandler implements RequestHandlerInterface
{
    protected SplStack $handlers;

    public function __construct()
    {
        $this->handlers = new SplStack();
    }

    public function push(RequestHandlerInterface $handler): static
    {
        $this->handlers->push($handler);
        return $this;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        if ($request->getHeaderLine('handler')) {
            foreach ($this->handlers as $handler) {
                /* @var RequestHandlerInterface $handler */
                if ($request->getHeaderLine('handler') == $handler::class) {
                    return $handler->handle($request);
                }
            }
            return create(NotFoundResponse::class);
        } else {
            $body = '';
            foreach ($this->handlers as $handler) {
                /* @var RequestHandlerInterface $handler */
                $body .= $handler->handle($request)->getBody()->getContents();
            }
            return create(HtmlResponse::class, $body);
        }
    }

}