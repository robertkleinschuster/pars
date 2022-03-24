<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewException;
use SplDoublyLinkedList;
use Traversable;

class DirectoryTreeModel extends TreeModel
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
     * @return DirectoryTreeModel
     */
    public function setDirectory(string $directory): DirectoryTreeModel
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
        foreach (glob("{$this->directory}/*") as $item) {
            $filename  = basename($item);
            $child = clone $this;
            $child->setValue($filename);
            if (is_dir($item)) {
                $child->setOpen(isset($this->current) && str_starts_with($this->current, "$item/"));
                $child->setDirectory($item);
            } else {
                $child->file = $item;
                $child->setActive(isset($this->current) && $this->current === $item);
                unset($child->directory);
            }
            yield $child;
        }
    }


    public function isList(): bool
    {
        return isset($this->directory);
    }

    /**
     * @param string $current
     * @return DirectoryTreeModel
     */
    public function setCurrent(string $current): DirectoryTreeModel
    {
        $this->current = $current;
        return $this;
    }
}
