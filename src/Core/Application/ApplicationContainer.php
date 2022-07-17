<?php

declare(strict_types=1);

namespace Pars\Core\Application;

use Laminas\ServiceManager\ServiceManager;

class ApplicationContainer extends ServiceManager
{
    public function __construct(ApplicationContainerConfig $config = null)
    {
        $config ??= new ApplicationContainerConfig();
        parent::__construct($config->toArray());
    }
}
