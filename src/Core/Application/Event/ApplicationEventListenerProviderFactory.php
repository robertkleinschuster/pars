<?php

namespace Pars\Core\Application\Event;

use Mezzio\Swoole\Exception\InvalidListenerException;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

class ApplicationEventListenerProviderFactory
{
    public function __invoke(ContainerInterface $container): ApplicationEventListenerProvider
    {
        $config = $container->has('config') ? $container->get('config') : [];
        Assert::isMap($config);

        $config = $config['application']['listeners'] ?? [];
        Assert::isMap($config);

        $provider = new ApplicationEventListenerProvider();

        foreach ($config as $event => $listeners) {
            Assert::stringNotEmpty($event);
            Assert::isList($listeners);

            /** @psalm-suppress MixedAssignment */
            foreach ($listeners as $listener) {
                Assert::true(is_string($listener) || is_callable($listener));
                $provider->addListener(
                    $event,
                    $this->prepareListener($container, $listener, $event)
                );
            }
        }

        return $provider;
    }


    private function prepareListener(ContainerInterface $container, $listener, string $event): callable
    {
        if (is_callable($listener)) {
            return $listener;
        }

        if (!$container->has($listener)) {
            throw InvalidListenerException::forNonexistentListenerType($listener, $event);
        }

        /** @psalm-suppress MixedAssignment */
        $listener = $container->get($listener);
        if (!is_callable($listener)) {
            throw InvalidListenerException::forListenerOfEvent($listener, $event);
        }

        return $listener;
    }
}
