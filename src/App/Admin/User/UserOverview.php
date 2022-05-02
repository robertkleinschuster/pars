<?php

namespace Pars\App\Admin\User;

use Pars\Core\View\Overview\Overview;

class UserOverview extends Overview
{
    public function init()
    {
        parent::init();
        $this->trow->model = new UserModel();
        $this->addField('Person_Name')->setEventLink(url('/user/:Person_ID'));
        $this->addField('User_Name')->setEventLink(url('/user/:Person_ID'));
    }
}
