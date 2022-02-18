<?php
namespace Pars\Core\Database\Adapter;

interface DbAdapter
{
    public function select(string $table);
    public function insert(string $table, array $data);
    public function delete(string $table, array $filter);
    public function deleteAll(string $table);
}
