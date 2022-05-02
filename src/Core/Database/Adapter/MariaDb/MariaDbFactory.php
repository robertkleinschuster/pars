<?php

namespace Pars\Core\Database\Adapter\MariaDb;

use Pars\Core\Container\ContainerFactoryInterface;
use PDO;

class MariaDbFactory implements ContainerFactoryInterface
{
    public function create(string $id)
    {
        $pdo = new PDO(config('db.dsn'), config('db.username'), config('db.password'));
        return new MariaDb($pdo);
    }
}
