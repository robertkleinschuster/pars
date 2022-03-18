<?php

use Pars\Core\Config\Config;
use Pars\Core\Translator\Translator;
use Pars\Core\Url\UriBuilder;
use Pars\Core\View\{ViewComponent, ViewRenderer};

function create(string $class, ...$params)
{
    $container = \Pars\Core\Container\Container::getInstance();
    return $container->create($class, ...$params);
}


function get(string $class, ...$params)
{
    $container = \Pars\Core\Container\Container::getInstance();
    return $container->get($class, ...$params);
}


function url(string $path = '/', $params = []): UriBuilder
{
    /* @var $builder UriBuilder */
    $builder = get(UriBuilder::class);
    return $builder->withPath($path)->withParams($params);
}


function __(string $code, array $placeholder = []): string
{
    /* @var $translator Translator */
    $translator = get(Translator::class);
    return $translator->translate($code, $placeholder);
}


function __pl(string $code, int $count, array $placeholder = []): string
{
    /* @var $translator Translator */
    $translator = get(Translator::class);
    return $translator->translatepl($code, $count, $placeholder);
}


function render(ViewComponent $component): string
{
    $renderer = new ViewRenderer();
    $renderer->setComponent($component);
    return $renderer->render();
}


function config(string $key)
{
    /* @var $config Config */
    $config = get(Config::class);
    return $config->get($key);
}
