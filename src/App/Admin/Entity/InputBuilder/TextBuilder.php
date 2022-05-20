<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\FormViewComponent;
use Pars\Core\View\Input\Input;

class TextBuilder extends BaseBuilder
{
    public function build(): FormViewComponent
    {
        $field = $this->getField();
        $input = new Input();
        $input->setEvent($this->createChangeEvent());
        $input->setId($this->getId());
        $input->setKey($field->getCode());
        $input->setLabel($field->getName());
        $input->setType($field->getInput()->getType());
        $input->setDisabled($field->getInput()->isDisabled());
        return $input;
    }
}
