<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\ViewEvent;

class ButtonBuilder extends TextBuilder
{
    protected function createEvent(): ViewEvent
    {
        $event = parent::createEvent();
        $event->setEvent('click');
        $event->setSelector('main');
        return $event;
    }
}
