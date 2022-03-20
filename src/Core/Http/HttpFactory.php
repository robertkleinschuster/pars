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
use Pars\Core\Http\Header\Accept\AcceptHeader;
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
    public function create(string $id)
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
        $request = ServerRequestCreator::create();
        return $request->withAttribute(AcceptHeader::class, new AcceptHeader($request));
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
