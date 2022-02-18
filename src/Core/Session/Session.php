<?php

namespace Pars\Core\Session;

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


    public function get(string $key)
    {
        return $_SESSION[$this->namespace][$key] ?? null;
    }

}