<?php

namespace Pars\App\Admin\Startpage;

use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Editor\Editor;
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
        $dirModel = new DirectoryTreeModel();
        $dirModel->setDirectory('userdata');
        $tree = $tree->setItemModel($dirModel);
        $tree->setHeading('start');

        $tree->getItem()->setEventLink(url('/:file'));
        $sidebar->setSideContent(render($tree));

        $file = $request->getAttribute('file');
        $file = str_replace('.', '', $file);
        $dirModel->setCurrent($file);
        if ($file && file_exists($file)) {
            if ($request->getMethod() === 'PATCH') {
                $content = $request->getBody()->getContents();
                file_put_contents($file, $content);
            }

            $editor = new Editor();
            $editor->setContent(file_get_contents($file));
            $sidebar->setContent(render($editor));
        }

        return response(render($sidebar));
    }
}
