<?php

namespace Pars\Core\Database\Adapter\MariaDb;

use PDO;

abstract class MariaDbStatement
{
    protected PDO $pdo;
    protected string $table;


    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    protected function quoteIdentifier(string $identifier): string
    {
        return "`$identifier`";
    }

    protected function quoteValue(string $value, string $type = PDO::PARAM_STR): string
    {
        return $this->pdo->quote($value, $type);
    }
}
