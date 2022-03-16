<?php

namespace Pars\Core\Http;

use Closure;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\UploadedFile;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\Container\NotFoundException;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;

use function in_array;

use const UPLOAD_ERR_OK;

class HttpFactory implements
    RequestFactoryInterface,
    ResponseFactoryInterface,
    ServerRequestFactoryInterface,
    StreamFactoryInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface,
    ContainerFactoryInterface
{
    public function createUploadedFile(
        StreamInterface $stream,
        int $size = null,
        int $error = UPLOAD_ERR_OK,
        string $clientFilename = null,
        string $clientMediaType = null
    ): UploadedFileInterface {
        if ($size === null) {
            $size = $stream->getSize();
        }

        return new UploadedFile($stream, $size, $error, $clientFilename, $clientMediaType);
    }

    public function createStream(string $content = ''): StreamInterface
    {
        return Utils::streamFor($content);
    }

    public function createStreamFromFile(string $file, string $mode = 'r'): StreamInterface
    {
        try {
            $resource = Utils::tryFopen($file, $mode);
        } catch (RuntimeException $e) {
            if ('' === $mode || false === in_array($mode[0], ['r', 'w', 'a', 'x', 'c'], true)) {
                throw new InvalidArgumentException(
                    sprintf('Invalid file opening mode "%s"', $mode),
                    0,
                    $e
                );
            }

            throw $e;
        }

        return Utils::streamFor($resource);
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        return Utils::streamFor($resource);
    }

    public function createServerRequest(
        string $method,
        $uri,
        array $serverParams = []
    ): ServerRequestInterface {
        if (empty($method)) {
            if (!empty($serverParams['REQUEST_METHOD'])) {
                $method = $serverParams['REQUEST_METHOD'];
            } else {
                throw new InvalidArgumentException('Cannot determine HTTP method');
            }
        }

        return new ServerRequest($method, $uri, [], null, '1.1', $serverParams);
    }

    public function createServerRequestFromGlobals(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }

    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return new Response($code, [], null, '1.1', $reasonPhrase);
    }

    public function createRequest(string $method, $uri): RequestInterface
    {
        return new Request($method, $uri);
    }

    public function createUri(string $uri = ''): UriInterface
    {
        return new Uri($uri);
    }

    public function create(array $params, string $id): mixed
    {
        switch ($id) {
            case ResponseInterface::class:
                return new Response(...$params);
            case HtmlResponse::class:
                return new Response(200, [], $params[0] ?? '');
            case RedirectResponse::class:
                return new Response(302, ['Location' => $params[0] ?? url()]);
            case NotFoundResponse::class:
                return $this->createNotFoundResponse();
            case ClosureResponse::class:
                return $this->createClosureResponse(...$params);
            case UriInterface::class:
                return $this->createUri(...$params);
            case StreamInterface::class:
                return $this->createStream(...$params);
            case ServerRequest::class:
                return (new ServerRequestFactory())->create($params, $id);
        }
        throw new NotFoundException('Unknown: ' . $id);
    }

    public function createNotFoundResponse(): NotFoundResponse
    {
        return new class extends Response implements NotFoundResponse {
            public function __construct(
                int $status = 404,
                array $headers = [],
                $body = null,
                string $version = '1.1',
                string $reason = null
            ) {
                parent::__construct($status, $headers, $body, $version, $reason);
            }
        };
    }

    public function createClosureResponse(Closure $closure, int $status = 200)
    {
        return new class ($status, [], new ClosureStream($closure)) extends Response implements ClosureResponse {
        };
    }
}
