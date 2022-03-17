<?php

namespace ParsTest\Core\Application\Bootstrap;

use Pars\Core\Application\Web\WebApplication;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MockFirstWebApplication extends WebApplication
{
    public bool $handled = false;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->handled = true;
        return parent::handle($request);
    }

}