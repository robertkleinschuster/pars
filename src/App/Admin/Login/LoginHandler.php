<?php
namespace Pars\App\Admin\Login;

use Pars\Core\Http\ClosureResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return create(ClosureResponse::class, $this->renderTemplate(...));
    }
    public function renderTemplate()
    {
        ob_start();
        include "templates/login.phtml";
        return ob_get_clean();
    }
}