<?php
namespace Pars\App\Admin\Startpage;

use Pars\App\Admin\Overview\OverviewHandler;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\View\Tree\Tree;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageSidebarHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $tree = new Tree();
        $tree->setHeading('start');
        $tree->getItem()->setLink(url('/:code'))->handler = OverviewHandler::class;
        $tree->addEntry('asdf')->addEntry('123')->addEntry('321')->addEntry('bbb', 'overview/123');
        $tree->addEntry('asdf', 'overview');
        $tree->addEntry('asdf');
        return create(HtmlResponse::class, render($tree, $this));
    }

}