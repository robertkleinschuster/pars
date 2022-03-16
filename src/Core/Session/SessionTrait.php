<?php

namespace Pars\Core\Session;

trait SessionTrait
{
    protected function getSession(): Session
    {
        return get(Session::class);
    }
}
