<?php

namespace Pars\App\Admin\Entity;

use Pars\App\Admin\User\UserModel;
use Pars\Core\View\Detail\Detail;

class EntityDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new UserModel();
        $this->addInput('name', 'name');
        $this->addInput('code', 'code');
        $this->addInput('state', 'state');
    }
    
    public function addInput(string $key, string $label, string $chapter = null, string $group = null)
    {
        $input = parent::addInput($key, $label, $chapter, $group);
        $input->model = $this->model;
        return $input;
    }
    
    
}
