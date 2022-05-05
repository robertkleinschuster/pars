<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\Http\Stream\QueueStream;
use Pars\Core\View\Group\ViewGroupHandler;
use Pars\Core\View\Toolbar\Toolbar;
use Pars\Core\View\ViewComponent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityDetailHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queueStream = new QueueStream();

        $id = $request->getAttribute('id');
        $component = new EntityDetail();
        $component->setId($id);
        $queueStream->push(render($component));

        $overview = new EntityOverviewHandler();
        $queueStream->push($overview->handle($request)->getBody());

        return response($queueStream);
    }
}
