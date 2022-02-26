<?php
namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewModel;

class TreeModel extends ViewModel
{
    public function addEntry(string $value, string $code = ''): static
    {
        $entry = new static();
        $entry->setValue($value);
        $entry->set('code', $code);
        $this->push($entry);
        return $entry;
    }
}