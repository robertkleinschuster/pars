<?php

namespace Pars\Core\Container;
require_once "global.php";

use Psr\Container\ContainerInterface;
use Pars\Core\Http\ClosureResponse;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\Http\HttpFactory;
use Pars\Core\Http\NotFoundResponse;
use Pars\Core\Http\RedirectResponse;
use Pars\Core\Http\ServerRequest;
use Pars\Core\Http\ServerRequestFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class Container implements ContainerInterface
{
    /**
     * @var ContainerFactoryInterface[]
     */
    protected array $factories = [];

    /**
     * @var array
     */
    protected array $services = [];

    /**
     * @var Container
     */
    public static Container $instance;

    /**
     * @var DefaultFactory
     */
    protected DefaultFactory $defaultFactory;

    public function __construct()
    {
        $this::$instance = $this;
        $this->defaultFactory = new DefaultFactory();
        $this->factories = array_replace_recursive($this->getDefaultFactories(), include "config/factories.php");
    }

    protected function getDefaultFactories(): array
    {
        return [
            UriFactoryInterface::class => HttpFactory::class,
            ServerRequestFactoryInterface::class => HttpFactory::class,
            RequestFactoryInterface::class => HttpFactory::class,
            ResponseFactoryInterface::class => HttpFactory::class,
            StreamFactoryInterface::class => HttpFactory::class,
            UploadedFileFactoryInterface::class => HttpFactory::class,
            ServerRequest::class => ServerRequestFactory::class,
            NotFoundResponse::class => HttpFactory::class,
            ClosureResponse::class => HttpFactory::class,
            UriInterface::class => HttpFactory::class,
            HtmlResponse::class => HttpFactory::class,
            RedirectResponse::class => HttpFactory::class,
            ResponseInterface::class => HttpFactory::class,
            StreamInterface::class => HttpFactory::class
        ];
    }

    /**
     * @param string $class
     * @param string $factory
     * @return void
     */
    public function register(string $class, string $factory)
    {
        $this->factories[$class] = $factory;
    }

    /**
     * @param string $id
     * @param mixed ...$params
     * @return mixed|object
     */
    public function get(string $id, ...$params): mixed
    {
        if (!isset($this->services[$id])) {
            $this->services[$id] = $this->create($id, ...$params);
        }
        return $this->services[$id];
    }

    /**
     * @param string $id
     * @param mixed ...$params
     * @return mixed
     */
    public function create(string $id, ...$params): mixed
    {
        $factory = $this->resolve($id);
        return $factory->create($params, $id);
    }

    /**
     * @param string $className
     * @return ContainerFactoryInterface
     */
    protected function resolve(string $className): ContainerFactoryInterface
    {
        if (isset($this->factories[$className]) && is_string($this->factories[$className])) {
            $this->factories[$className] = new ($this->factories[$className]);
        }
        return $this->factories[$className] ?? $this->defaultFactory;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->factories[$id]) || $this->services[$id];
    }

}