<?php
namespace Pars\Core\Database\Adapter\SQLite3;

interface SQLite3Migration
{
    public function execute(SQLite3 $adapter);
}
