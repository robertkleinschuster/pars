<?php

namespace Pars\Core\Application\Server\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class MessageEvent implements StoppableEventInterface
{
    private Frame $frame;
    private Server $server;

    /**
     * @param Frame $frame
     */
    public function __construct(Server $server, Frame $frame)
    {
        $this->server = $server;
        $this->frame = $frame;
    }

    /**
     * @return Frame
     */
    public function getFrame(): Frame
    {
        return $this->frame;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }


    public function isPropagationStopped(): bool
    {
        return false;
    }
}