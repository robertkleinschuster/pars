<?php

namespace Pars\App\Admin\Startpage;

use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Desktop\Desktop;
use Pars\Core\View\Group\ViewGroupHandler;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\Search\Search;
use Pars\Core\View\Sidebar\Sidebar;
use Pars\Core\View\Tree\DirectoryTreeModel;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
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
        $desktop = new Desktop();
        $desktop->getIcon()->setEventAction();

        $model = new ViewModel();
        $model->set('icon', 'file');
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);
        $desktop->getIcon()->getModel()->push($model);

        return response($this->render($desktop));
    }

    private function render(ViewComponent $component): StreamInterface
    {
        $this->renderer->setComponent($component);
        return $this->renderer->render();
    }
}
