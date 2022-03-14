<?php

namespace Pars\App\Frontend;

use Pars\App\Frontend\Favicon\FaviconMiddleware;
use Pars\App\Frontend\Startpage\StartpageHandler;
use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Middleware\NotFoundMiddleware;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FrontendApplication extends WebApplication
{

    protected function init()
    {
        $this->container->register(NotFoundMiddleware::class, Error\NotFoundMiddleware::class);
        $this->router->route('/', $this->container->get(StartpageHandler::class));
    }
}
