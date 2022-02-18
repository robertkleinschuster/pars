<?php
namespace Pars\Core\Database\Adapter;

use Pars\Core\Container\ContainerFactoryInterface;

class SQLite3Factory implements ContainerFactoryInterface
{
    public function create(array $params, string $id)
    {
        $config = config('database.sqlite3');
        if (!isset($config['file'])) {
            throw new \Exception('No file for sqlite3 provided.');
        }
        return new SQLite3($config['file']);
    }


}
