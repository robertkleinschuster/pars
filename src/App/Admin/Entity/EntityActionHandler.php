<?php

namespace Pars\App\Admin\Entity;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityActionHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $repo = new EntityRepository();
        $id = $request->getAttribute('id');
        if ($id) {
            $entity = $repo->findById($id);
        } else {
            $entity = new Entity();
        }
    
        $data = $request->getParsedBody();
    
        if (isset($data['state'])) {
            $entity->setState($data['state']);
        }
        
        if (isset($data['name'])) {
            $entity->setName($data['name']);
        }
    
        if (isset($data['code'])) {
            $entity->setCode($data['code']);
        }
    
        $repo->save($entity);
        
        return redirect_response(url());
    }
    
}
