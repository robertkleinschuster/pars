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

        $id = explode('/', $request->getAttribute('id'));
        $component = new EntityDetail();
        $component->setId(array_pop($id));
        $queueStream->push(render($component));

        if ($component->getModel()->getType()->isAllowChildren()) {
            $params = $request->getQueryParams();
            $params['mode'] = 'child';
            $params['type'] = $component->getModel()->getType()->getChildType();
            $overview = new EntityOverviewHandler();
            $queueStream->push($overview->handle($request->withQueryParams($params))->getBody());
        }

        return response($queueStream);
    }
}
