<?php
if (!function_exists('create')) {
    function create(string $class, ...$params)
    {
        $container = \Pars\Core\Container\Container::$instance;
        return $container->create($class, ...$params);
    }
}

if (!function_exists('get')) {
    function get(string $class, ...$params)
    {
        $container = \Pars\Core\Container\Container::$instance;
        return $container->get($class, ...$params);
    }
}

if (!function_exists('url')) {
    function url(string $path = '', $params = []): \Pars\Core\Url\UrlBuilder {
        /* @var $builder \Pars\Core\Url\UrlBuilder */
        $builder = get(\Pars\Core\Url\UrlBuilder::class);
        return $builder->withPath($path)->withParams($params);
    }
}

if (!function_exists('__')) {
    function __(string $code, array $placeholder = []) {
        /* @var $translator \Pars\Core\Translator\Translator */
        $translator = get(\Pars\Core\Translator\Translator::class);
        return $translator->translate($code, $placeholder);
    }
}

if (!function_exists('__pl')) {
    function __pl(string $code, int $count, array $placeholder = []) {
        /* @var $translator \Pars\Core\Translator\Translator */
        $translator = get(\Pars\Core\Translator\Translator::class);
        return $translator->translatepl($code, $count, $placeholder);
    }
}

if (!function_exists('render')) {
    function render(\Pars\Core\View\ViewComponent $component) {
        $renderer = new \Pars\Core\View\ViewRenderer();
        $renderer->setComponent($component);
        return $renderer->render();
    }
}