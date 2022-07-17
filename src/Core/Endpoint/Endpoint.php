<?php

namespace Pars\Core\Endpoint;

class Endpoint
{
    private string $app;
    private ?string $domain;
    private ?string $path = null;

    /**
     * @return string
     */
    public function getApp(): string
    {
        return $this->app;
    }

    /**
     * @param string $app
     * @return Endpoint
     */
    public function setApp(string $app): Endpoint
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string|null $domain
     * @return Endpoint
     */
    public function setDomain(?string $domain): Endpoint
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return Endpoint
     */
    public function setPath(?string $path): Endpoint
    {
        $this->path = $path;
        return $this;
    }
}