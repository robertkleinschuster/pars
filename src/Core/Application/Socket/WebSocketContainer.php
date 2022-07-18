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
        if (!isset($this->sockets[$id])) {
            $this->sockets[$id] = new WebSocket($id);
        }

        return $this->sockets[$id];
    }

    public function hasById(string $id): bool
    {
        return isset($this->sockets[$id]);
    }
}
