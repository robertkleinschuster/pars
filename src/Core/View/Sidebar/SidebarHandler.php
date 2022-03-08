<?php
namespace Pars\Core\View\Sidebar;

use Pars\Core\Http\HtmlResponse;
use Pars\Core\View\ViewPrefix;
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
        $prefixer = new ViewPrefix();
        if ($request->getHeaderLine('handler') === 'sidebar_side') {
            return $this->sideHandler->handle($request);
        } else if ($request->getHeaderLine('handler')) {
            return $this->contentHandler->handle($request);
        }

        $content = $this->contentHandler->handle($request)->getBody()->getContents();
        $content = $prefixer->addData($content, ['handler' => 'sidebar_content']);
        $side = $this->sideHandler->handle($request)->getBody()->getContents();
        $side = $prefixer->addData($side, ['handler' => 'sidebar_side']);
        $this->sidebar->setContent($content);
        $this->sidebar->setSideContent($side);

        return create(HtmlResponse::class, render($this->sidebar));
    }

}