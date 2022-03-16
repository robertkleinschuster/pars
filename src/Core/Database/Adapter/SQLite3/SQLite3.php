<?php

namespace Pars\Core\Database\Adapter\SQLite3;

use Pars\Core\Database\Adapter\DbAdapter;
use Pars\Core\Database\DatabaseResult;
use SQLite3 as PDOSQLite3;

class SQLite3 implements DbAdapter
{
    protected PDOSQLite3 $pdo;
    protected SQLite3MigrationRunner $migration;

    public function __construct(string $file)
    {
        $this->pdo = new PDOSQLite3($file);
        $this->getMigration()->run();
    }

    /**
     * @return SQLite3MigrationRunner
     */
    public function getMigration(): SQLite3MigrationRunner
    {
        if (!isset($this->migration)) {
            $this->migration = get(SQLite3MigrationRunner::class, $this);
        }

        return $this->migration;
    }

    public function exec(string $stmt)
    {
        return $this->pdo->exec($stmt);
    }

    public function select(string $table)
    {
        $table = $this->escapeTableName($table);
        $stmt = $this->pdo->prepare("SELECT * FROM $table");
        return $this->convertDatabaseResult($stmt->execute());
    }

    public function convertDatabaseResult(\SQLite3Result $result): DatabaseResult
    {
        $generator = function () use ($result) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                yield $row;
            }
        };
        return new DatabaseResult($generator());
    }

    public function insert(string $table, array $data)
    {
        $table = $this->escapeTableName($table);
        $placholder = $this->buildPlacholdersForData($data);
        $implodeKeys = implode(', ', $placholder);
        $stmt = $this->pdo->prepare("INSERT INTO $table VALUES ($implodeKeys)");
        foreach ($placholder as $column => $key) {
            $stmt->bindValue($key, $data[$column]);
        }
        return $this->convertDatabaseResult($stmt->execute());
    }


    public function delete(string $table, array $filter)
    {
        if (empty($filter)) {
            throw new \Exception("Can't delete without filter.");
        }
        $table = $this->escapeTableName($table);
        $placholder = $this->buildPlacholdersForData($filter);
        $where = [];
        foreach ($placholder as $column => $key) {
            $where[] = "$column = $key";
        }
        $whereString = implode(' AND ', $where);

        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE $whereString");
        foreach ($placholder as $column => $key) {
            $stmt->bindValue($key, $filter[$column]);
        }

        return $this->convertDatabaseResult($stmt->execute());
    }

    public function deleteAll(string $table)
    {
        $table = $this->escapeTableName($table);
        $stmt = $this->pdo->prepare("DELETE FROM $table");
        return $this->convertDatabaseResult($stmt->execute());
    }

    public function escapeTableName(string $table)
    {
        return PDOSQLite3::escapeString($table);
    }


    public function buildPlacholdersForData(array $data)
    {
        $placeholder = [];
        $index = 1;
        foreach ($data as $key => $value) {
            $key = PDOSQLite3::escapeString($key);
            $placeholder[$key] = ':p' . $index++;
        }
        return $placeholder;
    }
}
