<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Entity\EntityActionHandler;
use Pars\App\Admin\Entity\EntityHandler;
use Pars\App\Admin\FileExplorer\BrowserHandler;
use Pars\App\Admin\Overview\OverviewActionHandler;
use Pars\App\Admin\Overview\OverviewHandler;
use Pars\App\Admin\Startpage\StartpageHandler;
use Pars\App\Admin\User\UserActionHandler;
use Pars\App\Admin\User\UserHandler;
use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Config\Config;
use Pars\Core\Container\ContainerResolver;
use Pars\Core\Session\SessionTrait;
use Pars\Core\Translator\Translator;
use Pars\Core\Util\Phpinfo\PhpinfoHandler;
use Pars\Core\View\Editor\FileEditorHandler;
use Pars\Core\View\Navigation\Navigation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class AdminApplication extends WebApplication
{
    use SessionTrait;

    protected function init()
    {
        parent::init();
        $this->route('/:id+', new EntityHandler());
        $this->routePost('/:id+', new EntityActionHandler());
        $this->route('/user', new UserHandler());
        $this->route('/user/:id', new UserHandler());
        $this->routePost('/user/:id', new UserActionHandler());
        $this->route('/overview', new OverviewHandler());
        $this->routePost('/overview', new OverviewActionHandler());

        $this->route('/testpage', $this->getContainer()->get(StartpageHandler::class));
        $this->route('/browser', $this->getContainer()->get(BrowserHandler::class));
        $this->route('/editor/:file+', $this->getContainer()->get(FileEditorHandler::class));
        $this->route('/phpinfo', $this->getContainer()->get(PhpinfoHandler::class));
    }

    public function override(ContainerResolver $resolver)
    {
        parent::override($resolver);
        $resolver->overrideFactory(Config::class, AdminConfigFactory::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->getTranslator()->addPath(__DIR__ . '/translations');
        $this->getLayout()->setHeader($this->renderHeader());
        $this->getLayout()->setTitle('admin');
        return parent::handle($request);
    }

    protected function renderHeader(): StreamInterface
    {
        $navigation = new Navigation();
        $navigation->addEntry(__('admin.navigation.startpage'), url('/'))
            ->addEntry('startpage subitem', url('/start-subitem'));
        $navigation->addEntry(__('admin.navigation.content'), url('/content'));
        $system = $navigation->addEntry(__('admin.navigation.system'), url('/system'));
        $system->addEntry('system subitem 1', url('/system-subitem'));
        $subitem = $system->addEntry('system subitem 2', url('/system-subitem'));
        $subitem->addEntry('system subsubitem', url('/system-subsubitem'));
        return render($navigation);
    }

    protected function getTranslator(): Translator
    {
        return get(Translator::class);
    }
}
