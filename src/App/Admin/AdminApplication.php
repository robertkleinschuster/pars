<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Entity\EntityDeleteHandler;
use Pars\App\Admin\Entity\EntityDetailHandler;
use Pars\App\Admin\Entity\EntityHandler;
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
        $navigation = new Navigation();
        $repo = new EntityRepository();
        $types = $navigation->addEntry(
            __('admin.navigation.entity.definition'),
            url('/entity', [Entity::TYPE_CONTEXT => Entity::CONTEXT_DEFINITION])
        );
        $filterEntity = new Entity();
        $filterEntity->clear();
        $filterEntity->setType(Entity::TYPE_TYPE);
        $filterEntity->setContext(Entity::CONTEXT_DEFINITION);
        foreach ($repo->find($filterEntity) as $entity) {
            /** @var Entity $entity */
            $types->addEntry(
                __("admin.navigation.entity.{$entity->getCode()}"),
                url('/entity', ['type' => $entity->getCode(), 'context' => $entity->getContext()])
            );
        }

        $types = $navigation->addEntry(
            __('admin.navigation.entity.data'),
            url('/entity', [Entity::TYPE_CONTEXT => Entity::CONTEXT_DATA])
        );
        $filterEntity = new Entity();
        $filterEntity->clear();
        $filterEntity->setContext(Entity::CONTEXT_DEFINITION);
        $filterEntity->setType(Entity::TYPE_DATA);
        foreach ($repo->find($filterEntity) as $entity) {
            /** @var Entity $entity */
            $types->addEntry(
                __("admin.navigation.entity.{$entity->getCode()}"),
                url('/entity', ['type' => $entity->getCode(), 'context' => Entity::CONTEXT_DATA])
            );
        }

        return render($navigation);
    }

    protected function getTranslator(): Translator
    {
        return get(Translator::class);
    }
}
