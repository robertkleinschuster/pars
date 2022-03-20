<?php

namespace Pars\Core\Container;

interface ContainerFactoryInterface
{
    public function create(string $id);
}
