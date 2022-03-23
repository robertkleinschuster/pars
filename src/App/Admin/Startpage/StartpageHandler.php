<?php

namespace Pars\App\Admin\Startpage;

use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Group\ViewGroupHandler;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\Sidebar\Sidebar;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    use SessionTrait;

    protected ViewRenderer $renderer;

    /**
     * @param ViewRenderer $renderer
     */
    public function __construct(ViewRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        #throw new \Exception('asdf');

        $request->getAttribute(Layout::class)->addTitle('startpage');
        $sidebar = new Sidebar();

        $tree = new Tree();
        $tree->setHeading('start');
        $tree->getItem()->setEventLink(url('/:code'));
        $tree->addEntry('asdf')->addEntry('123')->addEntry('321')->addEntry('bbb', 'overview/123');
        $tree->addEntry('asdf', 'overview');
        $tree->addEntry('asdf');

        $sidebar->setSideContent(render($tree));
        $routeGroup = new ViewGroupHandler();
        $routeGroup->push($request->withUri($request->getUri()->withPath('/overview/detail')));
        $routeGroup->push($request->withUri($request->getUri()->withPath('/overview')));
        $sidebar->setContent($routeGroup->handle($request)->getBody());
        return response(render($sidebar));
    }
}
