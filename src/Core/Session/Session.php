<?php

namespace Pars\Core\Session;

use SplDoublyLinkedList;

class Session
{
    protected string $name = 'sid';
    protected string $id;
    protected string $namespace;

    public function __construct()
    {
        session_name($this->name);
        session_start();
        $this->id = session_id();
        $this->namespace = 'default';
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function set(string $key, $value): self
    {
        $_SESSION[$this->namespace][$key] = $value;
        return $this;
    }

    public function get(string $key, $default = null)
    {
        return $_SESSION[$this->namespace][$key] ?? $default;
    }

    public function getArray(string $key): array
    {
        return $this->get($key, []);
    }

}