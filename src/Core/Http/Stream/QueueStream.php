<?php

namespace Pars\Core\Http\Stream;

use Psr\Http\Message\StreamInterface;
use RuntimeException;
use SplQueue;

use function headers_sent;
use function ob_get_clean;
use function ob_start;

class QueueStream implements StreamInterface
{
    /**
     * @var iterable<StreamInterface>&SplQueue<StreamInterface>
     */
    protected SplQueue $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    public function push(StreamInterface $stream): self
    {
        $this->queue->push($stream);
        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->queue->isEmpty();
    }

    public function __toString()
    {
        if (headers_sent()) {
            foreach ($this->queue as $stream) {
                echo $stream;
                flush();
            }
            return '';
        } else {
            ob_start();
            foreach ($this->queue as $stream) {
                echo $stream;
            }
            return ob_get_clean();
        }
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
        return $this->queue->key();
    }

    public function eof()
    {
        return $this->queue->valid();
    }

    public function isSeekable()
    {
        return true;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new RuntimeException('Not seekable');
    }

    public function rewind()
    {
        $this->seek(0);
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

    public function getContents()
    {
        ob_start();
        echo $this->__toString();
        return ob_get_clean();
    }

    public function getMetadata($key = null)
    {
        return null;
    }
}
