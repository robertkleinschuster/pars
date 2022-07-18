<?php

namespace Pars\Core\Application\Socket;

use Swoole\WebSocket\Server;

class WebSocket
{
    private Server $server;
    private int $fd;
    private string $id;
    private array $listeners = [];

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getFd(): int
    {
        $this->assertConnection();
        return $this->fd;
    }

    /**
     * @param int $fd
     * @return WebSocket
     */
    public function setFd(int $fd): WebSocket
    {
        $this->fd = $fd;
        return $this;
    }

    /**
     * @param Server $server
     * @return WebSocket
     */
    public function setServer(Server $server): WebSocket
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function send(string $data)
    {
        $this->assertConnection();
        $this->server->push($this->getFd(), $data);
    }

    private function assertConnection()
    {
        if (!$this->isConnected()) {
            throw new \Exception('Not connected');
        }
    }

    public function isConnected(): bool
    {
        return isset($this->fd) && isset($this->server);
    }

    public function onMessage(callable $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * @return array
     */
    public function getListeners(): array
    {
        return $this->listeners;
    }
}
