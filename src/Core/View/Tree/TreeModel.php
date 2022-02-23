<?php
namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewModel;

class TreeModel extends ViewModel
{
    public function addEntry(string $value): static
    {
        $entry = new static();
        $entry->setValue($value);
        $this->push($entry);
        return $entry;
    }
}