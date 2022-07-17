<?php

namespace Pars\Core\Application\Server\HandlerRunner;

use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Pars\Core\Application\Server\Event\MessageEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server as SwooleWebSocketServer;
use Mezzio\Swoole\SwooleRequestHandlerRunner as MezzioSwooleRunner;

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
        $runner = new MezzioSwooleRunner($this->server, $this->dispatcher);
        $runner->run();
    }

    public function onMessage(SwooleWebSocketServer $server, Frame $frame)
    {
        $this->dispatcher->dispatch(new MessageEvent($server, $frame));
    }
}
