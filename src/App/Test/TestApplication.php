<?php

namespace Pars\App\Test;

use Laminas\Diactoros\Response\HtmlResponse;
use Pars\Core\Application\AbstractApplication;
use Pars\Core\Application\ApplicationContainer;
use Pars\Core\Application\ApplicationContainerConfig;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;

class TestApplication extends AbstractApplication
{
    public function __construct(ApplicationContainer $container)
    {
        $config = new ApplicationContainerConfig();
        $config->addArray([
            'debug' => $container->get('config')['debug']
        ]);
        $config->addProviderClass(\Pars\Core\Http\ConfigProvider::class);
        $config->addProviderClass(\Pars\Core\Translator\ConfigProvider::class);
        $config->addProviderClass(\Pars\Core\View\ConfigProvider::class);
        parent::__construct(new ApplicationContainer($config));
    }

    protected function init()
    {
        $this->route('/', function () {
            $layout = new Layout();
            $renderer = $this->getContainer()->get(ViewRenderer::class);
            $renderer->setComponent($layout);
            return new HtmlResponse($renderer->render());
        });
    }
}
