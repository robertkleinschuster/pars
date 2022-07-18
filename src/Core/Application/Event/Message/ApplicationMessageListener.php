<?php

namespace Pars\Core\Application\Event\Message;


use Pars\Core\Application\Socket\WebSocketContainer;

class ApplicationMessageListener
{
    private WebSocketContainer $container;

    private array $handlers = [];

    /**
     * @param WebSocketContainer $container
     */
    public function __construct(WebSocketContainer $container)
    {
        $this->container = $container;
    }

    public function __invoke(ApplicationMessageEvent $event)
    {
        $frame = $event->getFrame();
        $server = $event->getServer();
        $id = $this->container->getByFd($frame->fd);
        foreach ($this->handlers as $handler) {
            $response = $handler($frame->data, $id);
            $server->push($frame->fd, $response);
        }
        $socket = $this->container->getByFd($frame->fd);
        foreach ($socket->getListeners() as $listener) {
            $listener($frame->data);
        }
    }

    public function addHandler(callable $handler): void
    {
        $this->handlers[] = $handler;
    }
}
