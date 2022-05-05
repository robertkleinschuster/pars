<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Entity\EntityDeleteHandler;
use Pars\App\Admin\Entity\EntityDetailHandler;
use Pars\App\Admin\Entity\EntityHandler;
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
use Pars\Core\View\Navigation\Navigation;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class AdminApplication extends WebApplication
{
    use SessionTrait;

    protected function init()
    {
        parent::init();

        $this->route('/entity/:id+', new EntityPostHandler(), 'POST');
        $this->route('/entity/:id+', new EntityDeleteHandler(), 'DELETE');
        $this->route('/entity', new EntityOverviewHandler());
        $this->route('/entity/:id', new EntityDetailHandler());


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
        $navigation = new EntityNavigation();
        $navigation->addType();
        $navigation->addType(Entity::TYPE_TYPE, Entity::CONTEXT_DEFINITION);
        return render($navigation);
    }



    protected function getTranslator(): Translator
    {
        return get(Translator::class);
    }
}
