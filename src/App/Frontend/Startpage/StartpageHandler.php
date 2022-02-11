<?php
namespace Pars\App\Frontend\Startpage;

use Pars\Core\Http\ClosureResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return create(ClosureResponse::class, $this->render(...));
    }

    public function render()
    {
        ob_start();
        include 'templates/startpage.phtml';
        return ob_get_clean();
    }
}