<?php

namespace Pars\Core\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected array $services = [];
    protected ContainerResolver $resolver;

    private static Container $instance;

    final private function __construct()
    {
        $this->requireFunctions();
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function get(string $id, ...$params): mixed
    {
        if (!isset($this->services[$id])) {
            $this->services[$id] = $this->create($id, ...$params);
        }
        return $this->services[$id];
    }

    public function has(string $id): bool
    {
        return $this->hasService($id) || $this->hasFactory($id);
    }

    public function create(string $id, ...$params): mixed
    {
        $factory = $this->getResolver()->resolveFactory($id);
        return $factory->create($params, $id);
    }

    protected function getResolver(): ContainerResolver
    {
        if (!isset($this->resolver)) {
            $this->resolver = new ContainerResolver($this);
        }
        return $this->resolver;
    }

    private function hasService(string $id): bool
    {
        return isset($this->services[$id]);
    }

    private function hasFactory(string $id): bool
    {
        return $this->getResolver()->hasFactory($id);
    }

    private function requireFunctions()
    {
        require_once "functions.php";
    }
}
