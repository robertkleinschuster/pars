<?php

namespace Pars\App\Admin;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Base\PathApplicationInterface;
use Pars\Core\Middleware\ClearcacheMiddleware;
use Pars\Core\Middleware\PhpinfoMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminApplication extends AbstractApplication implements PathApplicationInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->handle($request);
    }

    public function getPath(): string
    {
        return '/admin';
    }

    protected function init()
    {
        $this->pipeline->pipe('/phpinfo', $this->container->get(PhpinfoMiddleware::class));
        $this->pipeline->pipe('/clearcache', $this->container->get(ClearcacheMiddleware::class));
    }


}