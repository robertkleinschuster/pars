<?php
namespace Pars\Core\View\Sidebar;

use Pars\Core\Http\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SidebarHandler implements RequestHandlerInterface
{
    protected Sidebar $sidebar;
    protected RequestHandlerInterface $sideHandler;
    protected RequestHandlerInterface $contentHandler;

    /**
     * @param RequestHandlerInterface $sideHandler
     * @param RequestHandlerInterface $contentHandler
     */
    public function __construct(RequestHandlerInterface $sideHandler, RequestHandlerInterface $contentHandler)
    {
        $this->sidebar = new Sidebar();
        $this->sideHandler = $sideHandler;
        $this->contentHandler = $contentHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getHeaderLine('handler') == $this->contentHandler::class) {
            return $this->contentHandler->handle($request);
        }

        if ($request->getHeaderLine('handler') == $this->sideHandler::class) {
            return $this->sideHandler->handle($request);
        }

        $content = $this->contentHandler->handle($request)->getBody()->getContents();
        $site = $this->sideHandler->handle($request)->getBody()->getContents();
        $this->sidebar->setContent($content);
        $this->sidebar->setSideContent($site);

        return create(HtmlResponse::class, render($this->sidebar));
    }

}