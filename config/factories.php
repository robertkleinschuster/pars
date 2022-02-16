<?php

use Pars\Core\Http\ClosureResponse;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\Http\HttpFactory;
use Pars\Core\Http\NotFoundResponse;
use Pars\Core\Http\RedirectResponse;
use Pars\Core\Http\ServerRequest;
use Pars\Core\Http\ServerRequestFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

return [
    UriFactoryInterface::class => HttpFactory::class,
    ServerRequestFactoryInterface::class => HttpFactory::class,
    RequestFactoryInterface::class => HttpFactory::class,
    ResponseFactoryInterface::class => HttpFactory::class,
    StreamFactoryInterface::class => HttpFactory::class,
    UploadedFileFactoryInterface::class => HttpFactory::class,
    ServerRequest::class => ServerRequestFactory::class,
    NotFoundResponse::class => HttpFactory::class,
    ClosureResponse::class => HttpFactory::class,
    UriInterface::class => HttpFactory::class,
    HtmlResponse::class => HttpFactory::class,
    RedirectResponse::class => HttpFactory::class,
    ResponseInterface::class => HttpFactory::class,
];