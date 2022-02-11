<?php

namespace Pars\Core\Application\Bootstrap;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Base\PathApplicationInterface;
use Pars\Core\Middleware\ErrorMiddleware;

class BootstrapApplication extends AbstractApplication
{
    protected function init()
    {
        $this->pipeline->pipe($this->container->get(ErrorMiddleware::class));
        $apps = require_once 'config/apps.php';
        foreach ($apps as $appClass) {
            /* @var $app AbstractApplication */
            $app = $this->container->get($appClass);
            if ($app instanceof PathApplicationInterface) {
                $this->pipeline->pipe($app->getPath(), $app);
            } else {
                $this->pipeline->pipe($app);
            }
        }
    }
}