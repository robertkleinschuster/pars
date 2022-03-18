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

    protected function init()
    {
        $this->pipe('/phpinfo', $this->getContainer()->get(PhpinfoMiddleware::class));
        $this->pipe('/clearcache', $this->getContainer()->get(ClearcacheMiddleware::class));
        $this->route('/', $this->getContainer()->get(StartpageHandler::class));
        $this->route('/:entity', $this->getContainer()->get(OverviewHandler::class));
        $this->route('/:entity/:id', $this->getContainer()->get(DetailHandler::class));
        $this->route('/login', $this->getContainer()->get(LoginHandler::class));
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->getTranslator()->addPath(__DIR__ . '/translations');
        $this->layout->setHeader($this->renderHeader());
        $this->layout->setTitle('admin');
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
        return $this->getContainer()->create(Navigation::class);
    }

    protected function createViewRenderer(): ViewRenderer
    {
        return $this->getContainer()->create(ViewRenderer::class);
    }

    protected function getTranslator(): Translator
    {
        return get(Translator::class);
    }
}
