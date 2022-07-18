<?php

namespace Pars\Core\Application\Socket;


class WebSocketContainer
{
    private array $sockets = [];

    public function add(WebSocket $socket): void
    {
        $this->sockets[$socket->getId()] = $socket;
    }

    public function getByFd(int $fd): WebSocket
    {
        foreach ($this->sockets as $socket) {
            if ($socket->getFd() == $fd) {
                return $socket;
            }
        }
        throw new \Exception('Missing socket for fd: ' . $fd);
    }

    public function getById(string $id): WebSocket
    {
        return $this->sockets[$id];
    }
}
