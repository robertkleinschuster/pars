<?php

use Pars\Core\Config\Config;
use Pars\Core\Container\Container;
use Pars\Core\Http\HttpFactory;
use Pars\Core\Stream\ClosureStream;
use Pars\Core\Translator\Translator;
use Pars\Core\Url\UriBuilder;
use Pars\Core\View\{ViewComponent, ViewRenderer};
use Psr\Http\Message\ResponseInterface;

function create(string $class, ...$params)
{
    $container = Container::getInstance();
    return $container->create($class, ...$params);
}

function get(string $class, ...$params)
{
    $container = Container::getInstance();
    return $container->get($class, ...$params);
}

function url(string $path = '/', $params = []): UriBuilder
{
    $container = Container::getInstance();
    /* @var UriBuilder $builder */
    $builder = $container->get(UriBuilder::class);
    return $builder->withPath($path)->withParams($params);
}

function __(string $code, array $placeholder = []): string
{
    $container = Container::getInstance();
    /* @var Translator $translator */
    $translator = $container->get(Translator::class);
    return $translator->translate($code, $placeholder);
}

function __pl(string $code, int $count, array $placeholder = []): string
{
    $container = Container::getInstance();
    /* @var Translator $translator */
    $translator = $container->get(Translator::class);
    return $translator->translatepl($code, $count, $placeholder);
}

function render(ViewComponent $component): string
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

function response(string|Closure $body, int $status = 200): ResponseInterface
{
    if (is_string($body)) {
        $stream = http()->streamFactory()->createStream($body);
    } else {
        $stream = new ClosureStream($body);
    }
    return http()
        ->responseFactory()
        ->createResponse()
        ->withBody($stream)
        ->withStatus($status);
}
