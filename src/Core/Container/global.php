<?php
if (!function_exists('create')) {
    function create(string $class, ...$params)
    {
        global $container;
        return $container->create($class, ...$params);
    }
}

if (!function_exists('get')) {
    function get(string $class, ...$params)
    {
        global $container;
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