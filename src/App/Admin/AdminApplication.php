<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Detail\DetailHandler;
use Pars\App\Admin\Login\LoginHandler;
use Pars\App\Admin\Overview\OverviewHandler;
use Pars\App\Admin\Startpage\StartpageHandler;
use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Middleware\ClearcacheMiddleware;
use Pars\Core\Middleware\PhpinfoMiddleware;
use Pars\Core\Session\SessionTrait;
use Pars\Core\Translator\Translator;
use Pars\Core\View\Navigation\Navigation;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminApplication extends WebApplication
{
    use SessionTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->layout->setHeader($this->renderHeader());
        return parent::handle($request);
    }


    protected function renderHeader(): string
    {
        $renderer = $this->createViewRenderer();
        $navigation = $this->createNavigationComponent();


        $navigation->addEntry(__('admin.navigation.startpage'), url())
            ->addEntry('startpage subitem', url('/start-subitem'));
        $navigation->addEntry(__('admin.navigation.content'), url('/content'));
        $system = $navigation->addEntry(__('admin.navigation.system'), url('/system'));
        $system->addEntry('system subitem 1', url('/system-subitem'));
        $subitem = $system->addEntry('system subitem 2', url('/system-subitem'));
        $subitem->addEntry('system subsubitem', url('/system-subsubitem'));
        $renderer->setComponent($navigation);
        return $renderer->render();
    }

    protected function createNavigationComponent(): Navigation
    {
        return $this->container->create(Navigation::class);
    }

    protected function createViewRenderer(): ViewRenderer
    {
        return $this->container->create(ViewRenderer::class);
    }

    protected function getTranslator(): Translator
    {
        return get(Translator::class);
    }



    protected function init()
    {
        $this->getTranslator()->addPath(__DIR__ . '/translations');
        $this->pipeline->pipe('/phpinfo', $this->container->get(PhpinfoMiddleware::class));
        $this->pipeline->pipe('/clearcache', $this->container->get(ClearcacheMiddleware::class));
        $this->router->route('/', $this->container->get(StartpageHandler::class));
        $this->router->route('/:entity', $this->container->get(OverviewHandler::class));
        $this->router->route('/:entity/:id', $this->container->get(DetailHandler::class));
        $this->router->route('/login', $this->container->get(LoginHandler::class));
    }


}
