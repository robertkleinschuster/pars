<?php

namespace Pars\Core\Database;

use Pars\Core\Database\Adapter\DbAdapter;

class Database
{
    protected DbAdapter $adapter;

    public function getAdapter(): DbAdapter
    {
        if (!isset($this->adapter)) {
            $this->adapter = get(DbAdapter::class);
        }
        return $this->adapter;
    }

    public function loadAllAssoc(string $table): array
    {
        $data = [];
        $dbResult = $this->getAdapter()->select($table);
        foreach ($dbResult as $item) {
            $data[] = $item;
        }

        return $data;
    }

    public function loadAllKeyValue(string $table, string $keyColumn, string $valueColumn): array
    {
        $data = [];
        foreach ($this->getAdapter()->select($table) as $item) {
            $data[$item[$keyColumn]] = $item[$valueColumn];
        }
        return $data;
    }

    public function save(string $table, array $data): DatabaseResult
    {
        return $this->getAdapter()->insert($table, $data);
    }

    public function delete(string $table, array $filter): DatabaseResult
    {
        return $this->getAdapter()->delete($table, $filter);
    }

    public function deleteAll(string $table)
    {
        return $this->getAdapter()->deleteAll($table);
    }
}
