<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Login\LoginHandler;
use Pars\App\Admin\Navigation\NavigationComponent;
use Pars\App\Admin\Startpage\StartpageHandler;
use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Base\PathApplicationInterface;
use Pars\Core\Middleware\ClearcacheMiddleware;
use Pars\Core\Middleware\PhpinfoMiddleware;
use Pars\Core\Stream\ClosureStream;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminApplication extends AbstractApplication implements PathApplicationInterface
{
    protected string $main;
    protected string $header;
    protected string $language;
    protected string $title;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->pipeline->handle($request);
        $this->main = $response->getBody()->getContents();
        $this->language = 'de';
        $this->title = 'PARS Admin';
        $this->header = $this->renderHeader();
        return $response->withBody(new ClosureStream($this->renderLayout(...)));
    }

    protected function renderHeader(): string
    {
        $renderer = $this->createViewRenderer();
        $navigation = $this->createNavigationComponent();
        $navigation->addEntry('Inhalte', url('/content'));
        $navigation->addEntry('System', url('/system'));
        $renderer->setComponent($navigation);
        return $renderer->render();
    }

    protected function createNavigationComponent(): NavigationComponent
    {
        return create(NavigationComponent::class);
    }

    protected function createViewRenderer(): ViewRenderer
    {
        return create(ViewRenderer::class);
    }

    public function renderLayout()
    {
        ob_start();
        include 'templates/layout.phtml';
        return ob_get_clean();
    }

    public function __get(string $name)
    {
        return '';
    }

    public function getPath(): string
    {
        return '/admin';
    }

    protected function init()
    {
        $this->pipeline->pipe('/phpinfo', $this->container->get(PhpinfoMiddleware::class));
        $this->pipeline->pipe('/clearcache', $this->container->get(ClearcacheMiddleware::class));
        $this->router->route('/login', $this->container->get(LoginHandler::class));
        $this->router->route('/', $this->container->get(StartpageHandler::class));
    }


}