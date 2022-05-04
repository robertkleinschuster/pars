<?php

namespace Pars\App\Admin\Entity;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $model = new EntityModel();
        $model->setId($request->getAttribute('id', ''));
        if ($model->isList()) {
            $component = new EntityOverview();
        } else {
            $component = new EntityDetail();
        }
        return response(render($component->withModel($model)));
    }
}
