<?php
namespace Pars\App\Admin\Startpage;

use Pars\App\Admin\Detail\DetailHandler;
use Pars\App\Admin\Overview\OverviewHandler;
use Pars\Core\View\Group\ViewComponentGroupHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageContentHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $overviewHandler = new OverviewHandler();
        $detailHandler = new DetailHandler();

        $groupHandler = new ViewComponentGroupHandler();
        $groupHandler->push($detailHandler);
        $groupHandler->push($overviewHandler);

        return $groupHandler->handle($request);
    }

}