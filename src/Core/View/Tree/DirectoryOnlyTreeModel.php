<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewException;
use SplDoublyLinkedList;
use Traversable;

class DirectoryOnlyTreeModel extends TreeModel
{
    private string $directory;

    protected string $file;

    private string $current;

    /**
     * @return string
     * @throws ViewException
     */
    public function getDirectory(): string
    {
        if (!isset($this->directory)) {
            throw new ViewException('Directory missing');
        }
        return $this->directory;
    }

    /**
     * @param string $directory
     * @return DirectoryOnlyTreeModel
     */
    public function setDirectory(string $directory): DirectoryOnlyTreeModel
    {
        $this->directory = $directory;
        return $this;
    }

    public function getList(): SplDoublyLinkedList
    {
        throw new ViewException('Unsupported');
    }

    public function getIterator(): Traversable
    {
        foreach (glob("{$this->getDirectory()}/*") as $item) {
            if (!is_dir($item)) {
                continue;
            }
            $child = clone $this;
            $filename = basename($item);
            $child->setValue(urldecode($filename));
            $child->setIcon('folder');
            
            unset($child->directory);

            yield $child;
        }
    }


    public function isList(): bool
    {
        return isset($this->directory);
    }

    /**
     * @param string $current
     * @return DirectoryOnlyTreeModel
     */
    public function setCurrent(string $current): DirectoryOnlyTreeModel
    {
        $this->current = $current;
        return $this;
    }
}
