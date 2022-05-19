<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Entity\EntityDeleteHandler;
use Pars\App\Admin\Entity\EntityDetailHandler;
use Pars\App\Admin\Entity\EntityNavigation;
use Pars\App\Admin\Entity\EntityOverviewHandler;
use Pars\App\Admin\Entity\EntityPostHandler;
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
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class AdminApplication extends WebApplication
{
    use SessionTrait;

    protected function init()
    {
        parent::init();
        sleep(1);
        (new EntityUpdater())->update();
        $this->getTranslator()->addPath(__DIR__ . '/translations');

        $this->route('/:id+', new EntityPostHandler(), 'POST');
        $this->route('/:id+', new EntityDeleteHandler(), 'DELETE');
        $this->route('/', new EntityOverviewHandler());
        $this->route('/:id+', new EntityDetailHandler());
    }

    public function override(ContainerResolver $resolver)
    {
        parent::override($resolver);
        $resolver->overrideFactory(Config::class, AdminConfigFactory::class);
    }

    protected function initLayout(ServerRequestInterface $request, ResponseInterface $response): void
    {
        parent::initLayout($request, $response);
        $this->getLayout()->setHeader($this->renderHeader());
        $this->getLayout()->setTitle('admin');
    }

    protected function renderHeader(): StreamInterface
    {
        $navigation = new EntityNavigation();
        return render($navigation);
    }



    protected function getTranslator(): Translator
    {
        return get(Translator::class);
    }
}
