<?php

namespace Pars\App\Admin\Entity;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Pars\Logic\Entity\EntityUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityPostHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        (new EntityUpdater())->update();

        $params = $request->getQueryParams();
        $repo = new EntityRepository();
        $id = $request->getAttribute('id');
        $hasParent = $params['hasParent'] ?? false;
        if ($id && !$hasParent) {
            $entity = $repo->findById($id);
        } else {
            $entity = new Entity();
            if ($hasParent) {
                $entity->setParent($id);
            }
        }

        $entity->from($request->getParsedBody());
        $repo->save($entity);

        return redirect_response(url(), 303);
    }
}
