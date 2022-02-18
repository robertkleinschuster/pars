<?php
namespace Pars\Core\Database;

trait DatabaseTrait
{
    protected function getDb(): Database
    {
        return get(Database::class);
    }
}
