<?php

namespace Pars\Core\Stream;

use Closure;
use Psr\Http\Message\StreamInterface;

class ClosureStream implements StreamInterface
{
    protected bool $executed = false;
    protected Closure $closure;

    /**
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function __toString()
    {
        return $this->getContents() ?? '';
    }

    public function getContents()
    {
        return $this->call();
    }

    protected function call()
    {
        $this->executed = true;
        return ($this->closure)();
    }

    public function close()
    {
        $this->executed = true;
    }

    public function detach()
    {

    }

    public function getSize()
    {
        return null;
    }

    public function tell()
    {

    }

    public function eof()
    {

    }

    public function isSeekable()
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {

    }

    public function isWritable()
    {
        return false;
    }

    public function write($string)
    {

    }

    public function isReadable()
    {
        return !$this->executed;
    }

    public function read($length)
    {
        return $this->call();
    }

    public function getMetadata($key = null)
    {
        return null;
    }

}