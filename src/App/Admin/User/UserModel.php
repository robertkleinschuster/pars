<?php

namespace Pars\App\Admin\User;

use Pars\Core\View\ViewModel;
use PDO;
use Traversable;

class UserModel extends ViewModel
{
    private string $id;

    public function getIterator(): Traversable
    {
        $pdo = new PDO(config('db.dsn'), config('db.username'), config('db.password'));
        $query = 'SELECT * FROM User INNER JOIN Person USING (Person_ID);';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($user = $stmt->fetchObject(static::class)) {
            yield $user;
        }
    }

    /**
     * @param string $id
     * @return UserModel
     */
    public function setId(string $id): UserModel
    {
        $this->id = $id;
        return $this;
    }


    public function isList(): bool
    {
        if (isset($this->id)) {
            $pdo = new PDO(config('db.dsn'), config('db.username'), config('db.password'));

            $query = 'SELECT * FROM User INNER JOIN Person USING (Person_ID) WHERE Person_ID = :id;';
            $stmt = $pdo->prepare($query);
            $stmt->bindValue('id', $this->id);
            $stmt->setFetchMode(PDO::FETCH_INTO, $this);
            $stmt->execute();
            $stmt->fetch();
            return false;
        }
        return true;
    }
}