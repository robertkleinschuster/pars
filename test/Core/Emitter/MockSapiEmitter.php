<?php

namespace ParsTest\Core\Emitter;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\Emitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;

class MockSapiEmitter extends SapiEmitter implements ContainerFactoryInterface
{
    protected ResponseInterface $response;

    public function emit(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function create(array $params, string $id): MockSapiEmitter
    {
        return new MockSapiEmitter();
    }
}
