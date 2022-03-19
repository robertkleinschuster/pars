<?php

namespace Pars\Core\Application\Web;

use Exception;
use Pars\Core\Application\Base\AbstractApplication;
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
        $this->getRenderer()->setComponent($this->getLayout());
    }

    /**
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = parent::handle($request->withAttribute(Layout::class, $this->getLayout()));
        $this->getLayout()->setMain($response->getBody()->getContents());
        $html = $this->getRenderer()->render();
        $body = $this->getHttp()->streamFactory()->createStream($html);
        return $response->withBody($body);
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
