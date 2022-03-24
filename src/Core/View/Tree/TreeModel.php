<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewModel;

class TreeModel extends ViewModel
{
    private bool $open = false;
    private bool $active = false;

    public function addEntry(string $value, string $code = ''): static
    {
        $entry = new static();
        $entry->setValue($value);
        $entry->set('code', $code);
        $this->push($entry);
        return $entry;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->open;
    }

    /**
     * @param bool $open
     * @return TreeModel
     */
    public function setOpen(bool $open): TreeModel
    {
        $this->open = $open;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return TreeModel
     */
    public function setActive(bool $active): TreeModel
    {
        $this->active = $active;
        return $this;
    }
}
