<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OverviewHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $entity = $request->getAttribute('entity');
        return create(ClosureResponse::class, $this->renderOverview(...));
    }

    public function renderOverview()
    {
        $overview = new OverviewComponent();

        $renderer = new ViewRenderer();
        $renderer->setComponent($overview);
        return $renderer->render();
    }

}