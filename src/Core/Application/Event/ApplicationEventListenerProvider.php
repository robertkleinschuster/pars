<?php

namespace Pars\Core\Application\Event;

use Psr\EventDispatcher\ListenerProviderInterface;

class ApplicationEventListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];

    public function getListenersForEvent(object $event): iterable
    {
        foreach ($this->listeners as $eventType => $listeners) {
            if (!$event instanceof $eventType) {
                continue;
            }

            foreach ($listeners as $listener) {
                yield $listener;
            }
        }
    }

    public function addListener(string $eventType, callable $listener): void
    {
        if (
            isset($this->listeners[$eventType])
            && in_array($listener, $this->listeners[$eventType], true)
        ) {
            return;
        }

        $this->listeners[$eventType][] = $listener;
    }
}
