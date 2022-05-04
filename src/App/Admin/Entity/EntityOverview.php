<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;
use Pars\Core\View\ViewModel;

class EntityOverview extends Overview
{
    public function init()
    {
        parent::init();
        $this->trow->model = new EntityModel();
        $this->addIconButton(Icon::edit())->setEventLink(url('/:id'));
        $this->addField('type', 'type');
        $this->addField('state', 'state');
        $this->addField('context', 'context');
        $this->addField('language', 'language');
        $this->addField('country', 'country');
        $this->addField('code', 'code');
        $this->addField('name', 'name');
    }
    
    public function withModel(ViewModel $model): static
    {
        $clone = clone $this;
        $clone->trow->model = $model;
        return $clone;
    }
}
