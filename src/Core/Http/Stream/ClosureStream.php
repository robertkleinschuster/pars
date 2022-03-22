<?php

namespace Pars\Core\Http\Stream;

use Closure;
use Exception;
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
        return $this->getContents();
    }

    public function getContents()
    {
        return $this->call() ?? '';
    }

    protected function call()
    {
        $this->executed = true;
        ob_start();
        echo ($this->closure)();
        return ob_get_clean();
    }

    public function close()
    {
        $this->executed = true;
    }

    public function detach()
    {
        return null;
    }

    public function getSize()
    {
        return null;
    }

    public function tell()
    {
        return 0;
    }

    public function eof()
    {
        return false;
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

    /**
     * @param string $string
     * @return int
     * @throws Exception
     */
    public function write($string)
    {
        throw new Exception('no supported');
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
