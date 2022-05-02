<?php

namespace Pars\App\Admin\User;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserActionHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $pdo = new PDO(config('db.dsn'), config('db.username'), config('db.password'));
        if ($id) {
            $data = $request->getParsedBody();
            if (isset($data['User_Name'])) {
                $query = "UPDATE User SET User_Name=:username WHERE Person_ID = :id;";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue('id', $id);
                $stmt->bindValue('username', $data['User_Name']);
                $stmt->execute();
            }
        } else {

            $query = "INSERT INTO Person (Person_Name) VALUES ('test') RETURNING Person_ID;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $person_ID = $stmt->fetchColumn();

            $query = "INSERT INTO User (Person_ID) VALUES (:id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue('id', $person_ID);
            $stmt->execute();

        }

        return http()->responseFactory()->createResponse(302)
            ->withHeader('Location', url()->__toString());
    }
}
