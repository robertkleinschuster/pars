<?php

namespace Pars\Core\Application\Server\Event\Message;

use Pars\Core\Application\Event\ApplicationEventDispatcher;
use Pars\Core\Application\Event\Message\ApplicationMessageEvent;
use Pars\Core\Application\Middleware\MiddlewareContainer;

class ServerMessageListener
{
    private MiddlewareContainer $container;

    /**
     * @param MiddlewareContainer $container
     */
    public function __construct(MiddlewareContainer $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerMessageEvent $event): void
    {
        foreach ($this->container->getApplications() as $application) {
            /**
             * @var ApplicationEventDispatcher $dispatcher
             */
            $dispatcher = $application->getContainer()->get(ApplicationEventDispatcher::class);
            $dispatcher->dispatch(new ApplicationMessageEvent($event->getServer(), $event->getFrame()));
        }
    }
}