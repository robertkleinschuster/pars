<?php

namespace Pars\Core\Application\Bootstrap;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Middleware\ErrorMiddleware;

class BootstrapApplication extends AbstractApplication
{
    protected function init()
    {
        $this->pipeline->pipe($this->container->get(ErrorMiddleware::class));
        foreach ($this->getApps() as $path => $appClass) {
            /* @var $app AbstractApplication */
            $app = $this->container->get($appClass);
            if (is_string($path)) {
                $this->pipeline->pipe($path, $app);
            } else {
                $this->pipeline->pipe($app);
            }
        }
    }

    protected function getApps(): array
    {
        return $this->config->get('apps', []);
    }
}
