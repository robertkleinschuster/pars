<?php
namespace Pars\App\Admin\Mvc;

use Pars\App\Admin\Menu\MenuComponent;
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
        $menu = new ViewComponent();
        $menu->push(new MenuComponent());
        $contentMenu = new ViewComponent();
        $contentMenu->getModel()->setValue('Inhalte');
        $menu->push($contentMenu);
        $systemMenu = new ViewComponent();
        $systemMenu->getModel()->setValue('System');
        $menu->push($systemMenu);
        $component = new ViewComponent();
        $component->push($menu);
        $component->getModel()->setValue('main');
        $this->renderer->setComponent($component);
        return create(ClosureResponse::class, $this->renderer->render(...));
    }

}