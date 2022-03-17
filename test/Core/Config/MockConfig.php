<?php

namespace ParsTest\Core\Config;

use Pars\Core\Config\Config;
use Pars\Core\Container\ContainerFactoryInterface;

class MockConfig extends Config implements ContainerFactoryInterface
{
    public function create(array $params, string $id): MockConfig
    {
        return new MockConfig();
    }

    public function set(string $key, $value): self
    {
        if (str_contains($key, '.')) {
            $data = $this->setRecursiveValue($value, $key);
            $this->data = array_replace_recursive($this->data, $data);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }

    protected function setRecursiveValue($data, $keyPath)
    {
        if (!is_array($keyPath)) {
            $keyPath = explode('.', $keyPath);
        }
        $key = array_shift($keyPath);
        if ($key) {
            $data = $this->setRecursiveValue($data, $keyPath);
            $data = [$key => $data];
        }
        return $data;
    }
}