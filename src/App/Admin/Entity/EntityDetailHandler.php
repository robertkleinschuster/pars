<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\Http\Stream\QueueStream;
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

        if ($component->getModel()->getEntityType()->isAllowChildren()) {
            $params = $request->getQueryParams();
            $params['mode'] = 'child';
            $overview = new EntityOverviewHandler();
            $queueStream->push($overview->handle($request->withQueryParams($params))->getBody());
        }

        return response($queueStream);
    }
}
