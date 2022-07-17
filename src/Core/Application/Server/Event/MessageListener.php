<?php

namespace Pars\Core\Application\Server\Event;

class MessageListener
{
    public function __invoke(MessageEvent $event): void
    {
        $server = $event->getServer();
        $frame = $event->getFrame();
        $server->push($frame->fd, "Hello: " . $frame->data);
    }
}