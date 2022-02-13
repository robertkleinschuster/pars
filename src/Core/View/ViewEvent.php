<?php
namespace Pars\Core\View;

class ViewEvent
{
    public string $event = 'click';
    public string $url = '';
    public string $handler = '';

    public function __construct()
    {
        $this->url = url();
    }


}