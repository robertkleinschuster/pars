<?php

namespace Pars\Core\Application\Middleware;

use Pars\Core\Application\AbstractApplication;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareContainer extends \Mezzio\MiddlewareContainer
{
    private ContainerInterface $applicationContainer;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->applicationContainer = $container;
    }

    public function get($service): MiddlewareInterface
    {
        if (class_exists($service) && in_array(AbstractApplication::class, class_parents($service))) {
            return new $service($this->applicationContainer);
        }
        return parent::get($service);
    }

    public function has($service): bool
    {
        return parent::has($service);
    }
}
