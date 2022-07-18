<?php

namespace Pars\Core\Application\Server\Event\Open;

use Swoole\Http\Request;
use Swoole\WebSocket\Server;

class ServerOpenEvent
{
    private Server $server;
    private Request $request;

    /**
     * @param Server $server
     * @param Request $request
     */
    public function __construct(Server $server, Request $request)
    {
        $this->server = $server;
        $this->request = $request;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}