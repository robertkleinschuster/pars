<?php
namespace Pars\App\Admin\Startpage;

use Pars\Core\Database\DatabaseTrait;
use Pars\Core\Http\ClosureResponse;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Editor\Editor;
use Pars\Core\View\Overview\Overview;
use Pars\Core\View\Sidebar\Sidebar;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\Tree\TreeItem;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    use SessionTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $tree = new Tree();
        $tree->setHeading('start');
        $tree->getItem()->setLink(url('/menu/:code'));
        $tree->addEntry('asdf')->addEntry('123')->addEntry('321')->addEntry('bbb');
        $tree->addEntry('asdf');
        $tree->addEntry('asdf');
        $sidebar = new Sidebar($tree);
        $overview = new Overview();
        $overview->setHeading('overview heading');
        $sidebar->push($overview);
        return create(HtmlResponse::class, render($sidebar));

    }

}