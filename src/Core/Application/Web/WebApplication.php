<?php

namespace Pars\Core\Application\Web;

use Exception;
use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\View\Entrypoints;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebApplication extends AbstractApplication
{
    protected Layout $layout;
    protected ViewRenderer $renderer;

    protected function init()
    {
        Entrypoints::add(Layout::getEntrypoint());
        $this->getRenderer()->setComponent($this->getLayout());
    }

    /**
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = parent::handle($request->withAttribute(Layout::class, $this->getLayout()));
        $this->initLayout($request, $response);
        return $response->withBody($this->getRenderer()->render());
    }

    protected function initLayout(ServerRequestInterface $request, ResponseInterface $response): void
    {
        $this->getLayout()->setMain($response->getBody());
        $hidden = array_map('trim', explode(',', $request->getHeaderLine('x-layout-hide')));
        $this->getLayout()->hide($hidden);
    }

    protected function getRenderer(): ViewRenderer
    {
        if (!isset($this->renderer)) {
            $this->renderer = clone $this->getContainer()->get(ViewRenderer::class);
        }
        return $this->renderer;
    }

    protected function getLayout(): Layout
    {
        if (!isset($this->layout)) {
            $this->layout = clone $this->getContainer()->get(Layout::class);
        }
        return $this->layout;
    }
}
