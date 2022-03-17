<?php

namespace ParsTest\Core\Application\Bootstrap;

use Pars\Core\Application\Web\WebApplication;
use ParsTest\Core\Application\Base\MiddlewareOrderTracker;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MockThirdWebApplication extends WebApplication
{
    public bool $handled = false;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->handled = true;
        return parent::handle($request);
    }

    protected function init()
    {
        parent::init();
        $this->pipe(new MiddlewareOrderTracker('third'));
    }
}