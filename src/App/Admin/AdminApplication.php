<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Entity\Detail\EntityDetailHandler;
use Pars\App\Admin\Entity\EntityDeleteHandler;
use Pars\App\Admin\Entity\EntityNavigation;
use Pars\App\Admin\Entity\EntityPostHandler;
use Pars\App\Admin\Entity\Overview\EntityOverviewHandler;
use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Config\Config;
use Pars\Core\Container\ContainerResolver;
use Pars\Core\Session\SessionTrait;
use Pars\Core\Translator\Translator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class AdminApplication extends WebApplication
{
    use SessionTrait;

    protected function init()
    {
        parent::init();
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
