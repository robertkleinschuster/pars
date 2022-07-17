<?php

namespace Pars\Core\Application\Server;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Swoole\ConfigProvider as SwooleConfigProvider;
use Pars\Core\Application\AbstractApplication;
use Pars\Core\Application\ApplicationContainer;
use Pars\Core\Application\ApplicationContainerConfig;
use Pars\Core\Application\Debug\ConfigProvider as DebugConfigProvider;
use Pars\Core\Application\Host\HostRouteMiddleware;

class ServerApplication extends AbstractApplication
{
    public function __construct(array $hosts = [], string $dev_domain = null)
    {
        $config = new ApplicationContainerConfig();
        $config->addArray(compact('hosts', 'dev_domain'));
        $config->addProviderClass(SwooleConfigProvider::class);
        $config->addProviderClass(ConfigProvider::class);
        if ($dev_domain) {
            $config->addProviderClass(DebugConfigProvider::class);
        }
        parent::__construct(new ApplicationContainer($config));
    }

    protected function init()
    {
        $this->pipe(ErrorHandler::class);
        $this->pipe(HostRouteMiddleware::class);
    }
}
