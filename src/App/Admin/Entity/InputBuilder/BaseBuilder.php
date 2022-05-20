<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\FormViewComponent;
use Pars\Core\View\ViewEvent;
use Pars\Logic\Entity\Info\EntityField;

abstract class BaseBuilder
{
    private EntityField $field;

    final public function __construct(EntityField $field)
    {
        $this->field = $field;
    }

    /**
     * @return EntityField
     */
    public function getField(): EntityField
    {
        return $this->field;
    }

    protected function createChangeEvent(): ViewEvent
    {
        $event = ViewEvent::action();
        $event->setMethod('POST');
        $event->setEvent('change');
        $event->setSelector("#{$this->getId()}");
        return $event;
    }

    protected function getId(): string
    {
        return $this->getField()->getNormalizedCode();
    }

    abstract public function build(): FormViewComponent;
}
