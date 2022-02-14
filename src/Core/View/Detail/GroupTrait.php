<?php

namespace Pars\Core\View\Detail;

trait GroupTrait
{
    protected array $group = [];

    public function getGroup(string $name): DetailGroup
    {
        if (!isset($this->group[$name])) {
            $this->group[$name] = create(DetailGroup::class);
            $this->group[$name]->setName($name);
            $this->push($this->group[$name]);
        }
        return $this->group[$name];
    }
}