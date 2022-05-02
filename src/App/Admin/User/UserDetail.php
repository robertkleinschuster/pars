<?php

namespace Pars\App\Admin\User;

use Pars\Core\View\Detail\Detail;
use Pars\Core\View\ViewEvent;

/**
 * @method UserModel getModel()
 */
class UserDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new UserModel();
        $input = $this->addInput('Person_Name', 'Name');
        $input->model = $this->model;
        $event = ViewEvent::action('');
        $event->event = 'change';
        $event->method = 'POST';
        $input = $this->addInput('User_Name', 'Username');
        $input->model = $this->model;
        $input->setEvent($event);
    }

    public function setId(string $id): self
    {
        $this->getModel()->setId($id);
        return $this;
    }
}