<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\Button\Button;
use Pars\Core\View\FormViewComponent;
use Pars\Core\View\Icon\Icon;
use Pars\Core\View\ViewEvent;

class ButtonBuilder extends BaseBuilder
{
    public function build(): FormViewComponent
    {
        $field = $this->getField();
        $button = new Button();
        $button->setEvent($this->createEvent());
        $button->setId($this->getId());
        $button->setKey($field->getCode());
        $button->setLabel($field->getName());
        if ($field->getIcon()) {
            $button->push((new Icon())->setIcon($field->getIcon()));
        }
        return $button;
    }

    protected function createEvent(): ViewEvent
    {
        $event = parent::createEvent();
        $event->setEvent('click');
        return $event;
    }
}
