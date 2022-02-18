<?php
namespace Pars\Core\Database\Adapter;

use SplStack;

class SQLite3MigrationRunner
{
    protected SQLite3 $adapter;

    protected SplStack $stack;


    /**
     * @param SQLite3 $adapter
     */
    public function __construct(SQLite3 $adapter)
    {
        $this->adapter = $adapter;
        $this->stack = new SplStack();
        foreach (config('database.sqlite3.migrations') ?? [] as $item) {
            $this->stack->push(get($item));
        }
    }

    public function run()
    {
        foreach ($this->stack as $item) {
            /* @var $item \Pars\Core\Database\Adapter\SQLite3Migration */
            $item->execute($this->adapter);
        }
    }
}
