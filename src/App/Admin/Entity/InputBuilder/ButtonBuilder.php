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
        if ($field->getIcon()) {
            $button->push((new Icon())->setIcon($field->getIcon()));
        } else {
            $button->setLabel($field->getName());
        }
        $button->getModel()->setValue($field->getDefaultValue());
        $button->getModel()->set($field->getCode(), $field->getDefaultValue());
        return $button;
    }

    protected function createEvent(): ViewEvent
    {
        $event = parent::createEvent();
        $event->setEvent('click');
        $event->setSelector('main');
        return $event;
    }
}
