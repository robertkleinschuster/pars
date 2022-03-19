<?php

namespace Pars\Core\Http;

use HttpSoft\Message\{RequestFactory,
    ResponseFactory,
    ServerRequestFactory,
    StreamFactory,
    UploadedFileFactory,
    UriFactory
};
use HttpSoft\ServerRequest\ServerRequestCreator;
use Pars\Core\Container\ContainerFactoryInterface;
use Psr\Http\Message\{RequestFactoryInterface,
    ResponseFactoryInterface,
    ServerRequestFactoryInterface,
    ServerRequestInterface,
    StreamFactoryInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface
};

class HttpFactory implements ContainerFactoryInterface
{
    public function create(array $params, string $id)
    {
        return match ($id) {
            RequestFactoryInterface::class => $this->requestFactory(),
            ResponseFactoryInterface::class => $this->responseFactory(),
            ServerRequestFactoryInterface::class => $this->serverRequestFactory(),
            StreamFactoryInterface::class => $this->streamFactory(),
            UploadedFileFactoryInterface::class => $this->uploadedFileFactory(),
            UriFactoryInterface::class => $this->uriFactory(),
            default => $this,
        };
    }

    public function createServerRequest(): ServerRequestInterface
    {
        return ServerRequestCreator::create();
    }

    public function requestFactory(): RequestFactoryInterface
    {
        return new RequestFactory();
    }

    public function responseFactory(): ResponseFactoryInterface
    {
        return new ResponseFactory();
    }

    public function serverRequestFactory(): ServerRequestFactoryInterface
    {
        return new ServerRequestFactory();
    }

    public function streamFactory(): StreamFactoryInterface
    {
        return new StreamFactory();
    }

    public function uploadedFileFactory(): UploadedFileFactoryInterface
    {
        return new UploadedFileFactory();
    }

    public function uriFactory(): UriFactoryInterface
    {
        return new UriFactory();
    }
}
