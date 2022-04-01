<?php

namespace Pars\App\Admin\Startpage;

use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Group\ViewGroupHandler;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\Search\Search;
use Pars\Core\View\Sidebar\Sidebar;
use Pars\Core\View\Tree\DirectoryTreeModel;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
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
        $search = new Search();
        $tree = new Tree();
        $tree->setToolbar($this->render($search));
        $tree->setBaseUri(url('/data/files/'));
        $dirModel = new DirectoryTreeModel();
        $dirModel->setDirectory('data/files');
        $tree = $tree->setItemModel($dirModel);
        $tree->setHeading('start');
        $tree->getItem()->setEventLink(url('/:file'));
        $file = $request->getAttribute('file', '');
        $sidebar = new Sidebar();

        $viewGroup = new ViewGroupHandler();

        if (str_starts_with($file, 'data/files')) {
            $dirModel->setCurrent($file);
            $viewGroup->push($request, "/editor/$file");
        }

        $viewGroup->push($request, "/overview");


        $sidebar->setContent($viewGroup->handle($request)->getBody());
        $sidebar->setSideContent($this->render($tree));
        return response($this->render($sidebar));
    }

    private function render(ViewComponent $component): StreamInterface
    {
        $this->renderer->setComponent($component);
        return $this->renderer->render();
    }
}
