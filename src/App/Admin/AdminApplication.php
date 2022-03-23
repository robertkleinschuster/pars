<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Detail\DetailHandler;
use Pars\App\Admin\Login\LoginHandler;
use Pars\App\Admin\Overview\OverviewHandler;
use Pars\App\Admin\Startpage\StartpageHandler;
use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Config\Config;
use Pars\Core\Container\ContainerResolver;
use Pars\Core\Session\SessionTrait;
use Pars\Core\Translator\Translator;
use Pars\Core\Util\Phpinfo\PhpinfoHandler;
use Pars\Core\View\Entrypoints;
use Pars\Core\View\Layout\Layout;
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
        #throw new \Exception('asdf');
        $this->route('/phpinfo', $this->getContainer()->get(PhpinfoHandler::class));
        $this->route('/', $this->getContainer()->get(StartpageHandler::class));
        $this->route('/:entity', $this->getContainer()->get(OverviewHandler::class));
        $this->route('/:entity/:id', $this->getContainer()->get(DetailHandler::class));
        $this->route('/login', $this->getContainer()->get(LoginHandler::class));
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
        $navigation->addEntry(__('admin.navigation.startpage'), url())
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
