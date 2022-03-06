<?php
namespace Pars\App\Admin\Startpage;

use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Sidebar\SidebarHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    use SessionTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $sidebar = new SidebarHandler(new StartpageSidebarHandler(), new StartpageContentHandler());
        return $sidebar->handle($request);

    }

}