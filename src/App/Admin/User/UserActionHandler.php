<?php

namespace Pars\App\Admin\User;

use Pars\Logic\User\User;
use Pars\Logic\User\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserActionHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $repo = new UserRepository();

        $id = $request->getAttribute('id');
        if ($id) {
            $user = $repo->findById($id);
        } else {
            $user = new User();
        }

        $data = $request->getParsedBody();

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }

        if (isset($data['password'])) {
            $user->setPassword($data['password']);
        }

        $repo->save($user);

        return http()->responseFactory()->createResponse(302)
            ->withHeader('Location', url()->__toString());
    }
}
