<?php
namespace Pars\App\Admin\Startpage;

use Pars\App\Admin\Detail\DetailHandler;
use Pars\App\Admin\Overview\OverviewHandler;
use Pars\Core\Database\DatabaseTrait;
use Pars\Core\Http\ClosureResponse;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Editor\Editor;
use Pars\Core\View\Overview\Overview;
use Pars\Core\View\Sidebar\Sidebar;
use Pars\Core\View\Sidebar\SidebarHandler;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\Tree\TreeItem;
use Pars\Core\View\ViewComponentHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    use SessionTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $sidebar = new SidebarHandler(new StartpageSidebarHandler(), new OverviewHandler());
        return $sidebar->handle($request);

    }

}