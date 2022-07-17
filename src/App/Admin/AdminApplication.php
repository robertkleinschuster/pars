<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Entity\Detail\EntityDetailHandler;
use Pars\App\Admin\Entity\EntityDeleteHandler;
use Pars\App\Admin\Entity\EntityPostHandler;
use Pars\App\Admin\Entity\Overview\EntityOverviewHandler;
use Pars\Core\Application\AbstractApplication;
use Pars\Core\Application\ApplicationContainer;
use Pars\Core\Application\ApplicationContainerConfig;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\View\ConfigProvider;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminApplication extends AbstractApplication
{
    public function __construct(ApplicationContainer $container)
    {
        $config = new ApplicationContainerConfig();
        $config->addArray([
            'debug' => $container->get('config')['debug']
        ]);
        $config->addProviderClass(ConfigProvider::class);
        parent::__construct(new ApplicationContainer($config));
    }

    protected function init()
    {
        $renderer = $this->getContainer()->get(ViewRenderer::class);
        $uriBuilder = $this->getContainer()->get(UriBuilder::class);
        $this->get('/', new EntityOverviewHandler($renderer, $uriBuilder));
        $this->get('/{id:.+}', new EntityDetailHandler($renderer, $uriBuilder));
        $this->post('/{id:.+}', new EntityPostHandler());
        $this->delete('/{id:.+}', new EntityDeleteHandler());
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $layout = new Layout();
        $response = parent::handle($request->withAttribute(Layout::class, $layout));
        $layout->setMain($response->getBody());
        $renderer = $this->getContainer()->get(ViewRenderer::class);
        $renderer->setComponent($layout);
        return $response->withBody($renderer->render());
    }
}
