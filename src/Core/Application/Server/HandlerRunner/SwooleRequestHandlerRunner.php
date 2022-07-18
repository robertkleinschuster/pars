<?php

namespace Pars\Core\Application\Server\HandlerRunner;

use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Mezzio\Swoole\SwooleRequestHandlerRunner as MezzioSwooleRunner;
use Pars\Core\Application\Server\Event\Message\ServerMessageEvent;
use Pars\Core\Application\Server\Event\Open\ServerOpenEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server as SwooleWebSocketServer;

class SwooleRequestHandlerRunner implements RequestHandlerRunnerInterface
{
    private SwooleWebSocketServer $server;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        SwooleWebSocketServer $server,
        EventDispatcherInterface $dispatcher
    ) {
        $this->server = $server;
        $this->dispatcher = $dispatcher;
    }

    public function run(): void
    {
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('open', [$this, 'onOpen']);
        $runner = new MezzioSwooleRunner($this->server, $this->dispatcher);
        $runner->run();
    }

    public function onOpen(SwooleWebSocketServer $server, Request $request)
    {
        $this->dispatcher->dispatch(new ServerOpenEvent($server, $request));
    }

    public function onMessage(SwooleWebSocketServer $server, Frame $frame)
    {
        $this->dispatcher->dispatch(new ServerMessageEvent($server, $frame));
    }
}
