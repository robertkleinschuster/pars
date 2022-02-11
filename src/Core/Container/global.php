<?php
if (!function_exists('create')) {
    function create(string $class, ...$params) {
        global $container;
        return $container->create($class, ...$params);
    }
}

if (!function_exists('get')) {
    function get(string $class, ...$params) {
        global $container;
        return $container->get($class, ...$params);
    }
}