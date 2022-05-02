<?php

namespace Pars\Core\Database\Adapter\MariaDb;

class MariaDbSelectStatement extends MariaDbStatement
{


    public function join()
    {
        return $this;
    }

    public function where()
    {
        return $this;
    }

    public function groupBy()
    {
        return $this;
    }

    public function orderBy()
    {
        return $this;
    }

    public function build()
    {
        $table = $this->quoteIdentifier($this->table);
        return $this->pdo->prepare("SELECT * FROM $table;");
    }


}