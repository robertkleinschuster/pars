<?php

namespace Pars\App\Admin\Startpage;

use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Group\ViewGroupHandler;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\Sidebar\Sidebar;
use Pars\Core\View\Tree\DirectoryTreeModel;
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
        $request->getAttribute(Layout::class)->addTitle('startpage');
        $sidebar = new Sidebar();

        $tree = new Tree();
        $tree->setBaseUri(url('/data/files/'));
        $dirModel = new DirectoryTreeModel();
        $dirModel->setDirectory('data/files');
        $tree = $tree->setItemModel($dirModel);
        $tree->setHeading('start');
        $tree->getItem()->setEventLink(url('/:file'));
        $file = $request->getAttribute('file', '');

        if (str_starts_with($file, 'data/files')) {
            $dirModel->setCurrent($file);
            $viewGroup = new ViewGroupHandler();
            $viewGroup->push($request, "/editor/$file");
            $sidebar->setContent($viewGroup->handle($request)->getBody());
        }

        $sidebar->setSideContent(render($tree));
        return response(render($sidebar));
    }
}
