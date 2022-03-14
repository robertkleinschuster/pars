<?php
namespace Pars\Core\Application\Web;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Container\Container;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class WebApplication extends AbstractApplication
{
    protected Layout $layout;
    protected ViewRenderer $renderer;

    public function __construct(Container $container = null)
    {
        parent::__construct($container);
        $this->layout = $this->container->get(Layout::class);
        $this->renderer = $this->container->get(ViewRenderer::class);
        $this->renderer->setComponent($this->layout);
    }

    protected function init()
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = parent::handle($request);
        $main = $response->getBody()->getContents();
        $this->layout->setMain($main);
        $html = $this->renderer->render();
        $body = $this->container->create(StreamInterface::class, $html);
        return $response->withBody($body);
    }



}