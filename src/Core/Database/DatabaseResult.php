<?php
namespace Pars\Core\Database;


use Traversable;

class DatabaseResult implements \IteratorAggregate
{
    protected Traversable $iterable;

    public function __construct(Traversable $iterable)
    {
        $this->iterable = $iterable;
    }

    public function getIterator()
    {
        return $this->iterable;
    }

}
