<?php

namespace Pars\Core\Http;

interface ServerRequestConstructorInterface
{
    public function __construct(
        string $method,
        $uri,
        array $headers = [],
        $body = null,
        string $version = '1.1'
    );
}
