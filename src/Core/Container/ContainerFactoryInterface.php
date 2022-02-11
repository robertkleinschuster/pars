<?php
namespace Pars\Core\Container;

interface ContainerFactoryInterface
{
    public function create(array $params, string $id): mixed;
}