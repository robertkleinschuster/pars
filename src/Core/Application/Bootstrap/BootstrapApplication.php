<?php

namespace Pars\Core\Application\Bootstrap;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Middleware\ErrorMiddleware;

class BootstrapApplication extends AbstractApplication
{
    protected function initPipeline()
    {
        $this->pipe($this->getContainer()->get(ErrorMiddleware::class));
        foreach ($this->getApps() as $path => $appClass) {
            /* @var $app AbstractApplication */
            $app = $this->getContainer()->get($appClass);
            if (is_string($path)) {
                $this->pipe($path, $app);
            } else {
                $this->pipe($app);
            }
        }
    }

    protected function init()
    {
    }


    protected function getApps(): array
    {
        return $this->getConfig()->get('apps', []);
    }
}
