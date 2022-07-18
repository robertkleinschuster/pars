<?php

namespace Pars\App\Test;

use Laminas\Diactoros\Response\HtmlResponse;
use Pars\Core\Application\AbstractApplication;
use Pars\Core\Application\ApplicationContainer;
use Pars\Core\Application\ApplicationContainerConfig;
use Pars\Core\Application\Socket\WebSocket;
use Pars\Core\Application\Socket\WebSocketContainer;
use Pars\Core\View\Button\Button;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewHelper;
use Pars\Core\View\ViewMessage;
use Pars\Core\View\ViewRenderer;
use Pars\Core\View\ViewSocket;
use Psr\Http\Message\ServerRequestInterface;

class TestApplication extends AbstractApplication
{
    public function __construct(ApplicationContainer $container)
    {
        $config = new ApplicationContainerConfig();
        $config->addArray([
            'debug' => $container->get('config')['debug']
        ]);
        $config->addProviderClass(\Pars\Core\Http\ConfigProvider::class);
        $config->addProviderClass(\Pars\Core\Translator\ConfigProvider::class);
        $config->addProviderClass(\Pars\Core\View\ConfigProvider::class);
        parent::__construct(new ApplicationContainer($config));
    }

    protected function init()
    {
        $this->route('/', function (ServerRequestInterface $request) {
            $layout = new Layout();
            $renderer = $this->getContainer()->get(ViewRenderer::class);

            $button = new Button();
            $viewHelper = new ViewHelper($button, new ViewSocket($request->getAttribute(WebSocket::class)));
            $button->setHelper($viewHelper);

            $button->setLabel('Send from: ' . $request->getAttribute(WebSocket::class)->getId());
            $renderer->setComponent($button);
            $layout->setMain($renderer->render());

            $button = new Button();
            $viewHelper = new ViewHelper($button, new ViewSocket($request->getAttribute(WebSocket::class)));
            $button->setHelper($viewHelper);

            $button->setLabel('Send from: ' . $request->getAttribute(WebSocket::class)->getId());
            $renderer->setComponent($button);
            $layout->setFooter($renderer->render());

            $renderer->setComponent($layout);
            return new HtmlResponse($renderer->render());
        });
    }

    public function getWebSocketContainer(): WebSocketContainer
    {
        return $this->getContainer()->get(WebSocketContainer::class);
    }
}
