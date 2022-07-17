<?php

use Pars\Core\Config\Config;
use Pars\Core\Container\Container;
use Pars\Core\Http\HttpFactory;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\Translator\Translator;
use Psr\Http\Message\StreamInterface;
use Pars\Core\View\{ViewComponent, ViewRenderer};
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;



function url(string $path = null, $params = []): UriBuilder
{
    return new UriBuilder(new \Laminas\Diactoros\UriFactory());
}

function __(string $code, array $placeholder = []): string
{
    return $code;
}

function __pl(string $code, int $count, array $placeholder = []): string
{
    return $code;
}

function render(ViewComponent $component): StreamInterface
{
    $container = Container::getInstance();
    /* @var ViewRenderer $renderer */
    $renderer = clone $container->get(ViewRenderer::class);
    $renderer->setComponent($component);
    return $renderer->render();
}

function config(string $key)
{
    $container = Container::getInstance();
    /* @var Config $config */
    $config = $container->get(Config::class);
    return $config->get($key);
}

function http(): HttpFactory
{
    $container = Container::getInstance();
    /* @var HttpFactory $http */
    return $container->get(HttpFactory::class);
}

function response(string|StreamInterface $body, int $status = 200): ResponseInterface
{
    if (is_string($body)) {
        $body = http()->streamFactory()->createStream($body);
    }
    return http()
        ->responseFactory()
        ->createResponse($status)
        ->withBody($body);
}

function redirect_response(string $location, int $code = 302): ResponseInterface
{
    return http()
        ->responseFactory()
        ->createResponse($code)
        ->withHeader('Location', $location);
}

function logger(): LoggerInterface
{
    $container = Container::getInstance();
    /* @var LoggerInterface $log */
    return $container->get(LoggerInterface::class);
}

function log_error($message): void
{
    logger()->error($message);
}

function log_info($message): void
{
    logger()->info($message);
}
