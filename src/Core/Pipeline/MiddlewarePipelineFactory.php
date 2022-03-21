<?php

namespace Pars\Core\Pipeline;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\Pipeline\BasePath\BasePathMiddlewareFactory;
use Psr\Container\ContainerInterface;

class MiddlewarePipelineFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $id, ...$params): MiddlewarePipeline
    {
        return new MiddlewarePipeline($params[0], new BasePathMiddlewareFactory($this->container));
    }
}
