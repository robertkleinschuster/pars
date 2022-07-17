<?php

namespace Pars\Core\Http\Stream;

use Closure;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

use function headers_sent;
use function ob_get_clean;
use function ob_start;

class ClosureStream implements StreamInterface
{
    protected Closure $closure;
    protected ?object $context;

    public function __construct(Closure $closure, object $context = null)
    {
        $this->closure = $closure;
        $this->context = $context;
    }

    public function __toString()
    {
        ob_start();
        echo $this->closure->call($this->getContext());
        return ob_get_clean();
    }

    private function getContext(): object
    {
        return $this->context ?? $this;
    }

    public function getContents()
    {
        ob_start();
        echo $this->__toString();
        return ob_get_clean();
    }

    public function close()
    {
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
        throw new RuntimeException('Not seekable');
    }

    public function rewind()
    {
        throw new RuntimeException('Unsupported');
    }

    public function isWritable()
    {
        return false;
    }

    public function write($string)
    {
        throw new RuntimeException('Not writeable');
    }

    public function isReadable()
    {
        return false;
    }

    public function read($length)
    {
        throw new RuntimeException('Not readable');
    }

    public function getMetadata($key = null)
    {
        return null;
    }
}
