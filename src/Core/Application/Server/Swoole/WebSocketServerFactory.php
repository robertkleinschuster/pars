<?php

namespace Pars\Core\Application\Server\Swoole;

use ArrayAccess;
use Mezzio\Swoole\HttpServerFactory;
use Psr\Container\ContainerInterface;
use Swoole\WebSocket\Server as SwooleWebSocketServer;
use Swoole\Runtime as SwooleRuntime;
use Webmozart\Assert\Assert;

class WebSocketServerFactory extends HttpServerFactory
{
    /**
     * Swoole server supported modes
     */
    private const MODES = [
        SWOOLE_BASE,
        SWOOLE_PROCESS,
    ];

    /**
     * Swoole server supported protocols
     */
    private const PROTOCOLS = [
        SWOOLE_SOCK_TCP,
        SWOOLE_SOCK_TCP6,
        SWOOLE_SOCK_UDP,
        SWOOLE_SOCK_UDP6,
        SWOOLE_UNIX_DGRAM,
        SWOOLE_UNIX_STREAM,
    ];

    public function __invoke(ContainerInterface $container): SwooleWebSocketServer
    {
        $config = $container->get('config');
        assert(is_array($config) || $config instanceof ArrayAccess);

        $swooleConfig = $config['mezzio-swoole'] ?? [];
        Assert::isMap($swooleConfig);

        $serverConfig = $swooleConfig['swoole-http-server'] ?? [];
        Assert::isMap($serverConfig);

        $host     = $serverConfig['host'] ?? static::DEFAULT_HOST;
        $port     = $serverConfig['port'] ?? static::DEFAULT_PORT;
        $mode     = $serverConfig['mode'] ?? SWOOLE_BASE;
        $protocol = $serverConfig['protocol'] ?? SWOOLE_SOCK_TCP;

        if ($port < 1 || $port > 65535) {
            throw new \Mezzio\Swoole\Exception\InvalidArgumentException('Invalid port');
        }

        if (! in_array($mode, self::MODES, true)) {
            throw new \Mezzio\Swoole\Exception\InvalidArgumentException('Invalid server mode');
        }

        $validProtocols = self::PROTOCOLS;
        if (defined('SWOOLE_SSL')) {
            $validProtocols[] = SWOOLE_SOCK_TCP | SWOOLE_SSL;
            $validProtocols[] = SWOOLE_SOCK_TCP6 | SWOOLE_SSL;
        }

        if (! in_array($protocol, $validProtocols, true)) {
            throw new \Mezzio\Swoole\Exception\InvalidArgumentException('Invalid server protocol');
        }

        $enableCoroutine = $swooleConfig['enable_coroutine'] ?? false;
        if ($enableCoroutine && method_exists(SwooleRuntime::class, 'enableCoroutine')) {
            SwooleRuntime::enableCoroutine();
        }

        $httpServer    = new SwooleWebSocketServer($host, $port, $mode, $protocol);
        $serverOptions = $serverConfig['options'] ?? [];

        Assert::isArray($serverOptions);

        $httpServer->set($serverOptions);

        return $httpServer;
    }

}