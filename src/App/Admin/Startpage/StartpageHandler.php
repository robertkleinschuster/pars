<?php
namespace Pars\App\Admin\Startpage;

use Pars\Core\Database\DatabaseTrait;
use Pars\Core\Http\ClosureResponse;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Editor\Editor;
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
        $tree->addEntry('asdf')->addEntry('123')->addEntry('321')->addEntry('bbb');
        $tree->addEntry('asdf');
        $tree->addEntry('asdf');
        return create(HtmlResponse::class, render($tree));

    }

    public function renderTemplate()
    {
        ob_start();
        include "templates/startpage.phtml";
        return ob_get_clean();
    }
}