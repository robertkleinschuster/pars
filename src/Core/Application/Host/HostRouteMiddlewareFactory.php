<?php

namespace Pars\Core\Application\Host;

use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

class HostRouteMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): HostRouteMiddleware
    {
        $hosts = $container->get('config')['hosts'] ?? [];
        $devDomain = $container->get('config')['dev_domain'] ?? null;
        if ($devDomain) {
            foreach ($hosts as $host => $handler) {
                $host = str_replace('.', '_', $host) . '.' . $devDomain;
                $hosts[$host] = $handler;
            }
        }
        return new HostRouteMiddleware(
            $container->get(MiddlewareFactory::class),
            $hosts
        );
    }
}
