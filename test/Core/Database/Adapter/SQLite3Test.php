<?php

namespace ParsTest\Core\Database\Adapter;

use Pars\Core\Container\Container;
use Pars\Core\Database\Adapter\SQLite3\SQLite3;

class SQLite3Test extends \PHPUnit\Framework\TestCase
{

    public function testBuildPlaceholderForData()
    {
        $container = new Container();
        $db = new SQLite3(__DIR__ . '/sqlite3.db');
        $placeholder = $db->buildPlacholdersForData(['Column' => 'value']);
        $this->assertEquals(['Column' => ':p1'], $placeholder);
    }

}
