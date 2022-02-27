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
    function url(string $path = '/', $params = []): \Pars\Core\Url\UrlBuilder
    {
        /* @var $builder \Pars\Core\Url\UrlBuilder */
        $builder = get(\Pars\Core\Url\UrlBuilder::class);
        return $builder->withPath($path)->withParams($params);
    }
}

if (!function_exists('__')) {
    function __(string $code, array $placeholder = [])
    {
        /* @var $translator \Pars\Core\Translator\Translator */
        $translator = get(\Pars\Core\Translator\Translator::class);
        return $translator->translate($code, $placeholder);
    }
}

if (!function_exists('__pl')) {
    function __pl(string $code, int $count, array $placeholder = [])
    {
        /* @var $translator \Pars\Core\Translator\Translator */
        $translator = get(\Pars\Core\Translator\Translator::class);
        return $translator->translatepl($code, $count, $placeholder);
    }
}

if (!function_exists('render')) {
    function render(\Pars\Core\View\ViewComponent $component, \Psr\Http\Server\RequestHandlerInterface $requestHandler = null)
    {
        $renderer = new \Pars\Core\View\ViewRenderer();
        $renderer->setComponent($component);
        if ($requestHandler) {
            $renderer->setHandler($requestHandler::class);
        }
        return $renderer->render();
    }
}

if (!function_exists('config')) {
    function config(string $key)
    {
        /* @var $config \Pars\Core\Config\Config */
        $config = get(\Pars\Core\Config\Config::class);
        return $config->get($key);
    }
}
