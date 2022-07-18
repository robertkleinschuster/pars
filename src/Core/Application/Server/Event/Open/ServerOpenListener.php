<?php

namespace Pars\Core\Application\Server\Event\Open;

use Pars\Core\Application\Event\ApplicationEventDispatcher;
use Pars\Core\Application\Event\Open\ApplicationOpenEvent;
use Pars\Core\Application\Middleware\MiddlewareContainer;

class ServerOpenListener
{
    private MiddlewareContainer $container;

    /**
     * @param MiddlewareContainer $container
     */
    public function __construct(MiddlewareContainer $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerOpenEvent $event): void
    {
        foreach ($this->container->getApplications() as $application) {
            /**
             * @var ApplicationEventDispatcher $dispatcher
             */
            $dispatcher = $application->getContainer()->get(ApplicationEventDispatcher::class);
            $dispatcher->dispatch(new ApplicationOpenEvent($event->getServer(), $event->getRequest()));
        }
    }
}