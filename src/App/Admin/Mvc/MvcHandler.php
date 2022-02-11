<?php
namespace Pars\App\Admin\Mvc;

use Pars\Core\Controller\Controller;
use Pars\Core\Controller\ControllerRequest;
use Pars\Core\Controller\ControllerResponse;
use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MvcHandler implements RequestHandlerInterface
{
    protected ViewRenderer $renderer;


    public function __construct()
    {
        $this->renderer = create(ViewRenderer::class);
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $controller = new Controller(new ControllerRequest(), new ControllerResponse(), $this->renderer);
        $controller->dispatch();
        return create(ClosureResponse::class, $this->renderer->render(...));
    }

}