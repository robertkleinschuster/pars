<?php

namespace Pars\Core\Session;

class Session
{
    protected string $name = 'sid';
    protected string $id;
    protected string $namespace;

    public function __construct()
    {
        if (php_sapi_name() != 'cli' && !headers_sent()) {
            session_name($this->name);
            session_start();
        }

        $id = session_id();
        if ($id) {
            $this->id = session_id();
        } else {
            $this->id = '';
        }
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
