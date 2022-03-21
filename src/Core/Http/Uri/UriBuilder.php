<?php

namespace Pars\Core\Http\Uri;

use Psr\Http\Message\{UriFactoryInterface, UriInterface};

class UriBuilder
{
    private UriInterface $baseUri;
    private UriInterface $uri;
    private UriFactoryInterface $factory;

    final public function __construct(UriFactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->baseUri = $this->factory->createUri();
        $this->uri = $this->factory->createUri();
    }

    public function addBaseUri(UriInterface $uri): UriBuilder
    {
        $this->baseUri = $this->merged($this->baseUri, $uri);
        return $this;
    }

    public function withUri(UriInterface $uri): UriBuilder
    {
        $clone = clone $this;
        $clone->uri = $uri;
        return $clone;
    }

    public function withParams(array $params): UriBuilder
    {
        $clone = clone $this;
        $clone->uri = $clone->uri->withQuery(http_build_query($params));
        return $clone;
    }

    public function withPath(string $path): UriBuilder
    {
        $clone = clone $this;
        $clone->uri = $clone->uri->withPath($path);
        return $clone;
    }

    public function __clone()
    {
        $this->baseUri = clone $this->baseUri;
        $this->uri = clone $this->uri;
    }

    public function merged(UriInterface $base, UriInterface $append): UriInterface
    {
        $result = $this->factory->createUri();
        $result = $result->withPath($base->getPath() . $append->getPath());
        if ($append->getQuery()) {
            if ($base->getQuery()) {
                $query = $base->getQuery() . '&' . $append->getQuery();
            } else {
                $query = $append->getQuery();
            }
            $result = $result->withQuery($query);
        }
        return $result;
    }

    public function build(): UriInterface
    {
        return $this->merged($this->baseUri, $this->uri);
    }

    public function __toString()
    {
        return $this->build()->__toString();
    }
}
