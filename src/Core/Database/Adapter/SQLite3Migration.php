<?php
namespace Pars\Core\Database\Adapter;

interface SQLite3Migration
{
    public function execute(SQLite3 $adapter);
}
