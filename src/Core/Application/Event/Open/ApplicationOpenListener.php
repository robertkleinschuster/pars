<?php

namespace Pars\Core\Application\Event\Open;

use Pars\Core\Application\Socket\WebSocketContainer;

class ApplicationOpenListener
{
    private WebSocketContainer $container;

    /**
     * @param WebSocketContainer $container
     */
    public function __construct(WebSocketContainer $container)
    {
        $this->container = $container;
    }

    public function __invoke(ApplicationOpenEvent $event)
    {
        $request = $event->getRequest();
        $server = $event->getServer();
        if ($this->container->hasById($request->cookie['client'])) {
            $this->container
                ->getById($request->cookie['client'])
                ->setServer($server)
                ->setFd($request->fd);
        } else {
            $server->push($request->fd, json_encode(['ctrl' => 'reload']));
        }
    }
}
