<?php

namespace Pars\Core\Database\Adapter\MariaDb;

use Pars\Core\Database\Adapter\DbAdapter;
use PDO;

class MariaDb implements DbAdapter
{
    private PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(string $table)
    {

        return new MariaDbSelectStatement($this->pdo, $table);
    }




    public function insert(string $table, array $data)
    {
        // TODO: Implement insert() method.
    }

    public function delete(string $table, array $filter)
    {
        // TODO: Implement delete() method.
    }

    public function deleteAll(string $table)
    {
        // TODO: Implement deleteAll() method.
    }

}