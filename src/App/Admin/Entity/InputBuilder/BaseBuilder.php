<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\FormViewComponent;
use Pars\Core\View\ViewEvent;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\Info\EntityField;

abstract class BaseBuilder
{
    private Entity $entity;
    private EntityField $field;

    final public function __construct(Entity $entity, EntityField $field)
    {
        $this->entity = $entity;
        $this->field = $field;
    }

    /**
     * @return Entity
     */
    public function getEntity(): Entity
    {
        return $this->entity;
    }

    /**
     * @return EntityField
     */
    public function getField(): EntityField
    {
        return $this->field;
    }

    protected function createEvent(): ViewEvent
    {
        $event = ViewEvent::action();
        $event->setMethod('POST');
        $event->setEvent('change');
        $event->setUrl(url()->withAppendedPath('/:id'));
        $event->setParam('redirect', url());
        if (EntityField::SCOPE_ENTRY === $this->getField()->getScope()) {
            $event->setSelector("#id-{$this->getEntity()->getId()}");
        } else {
            $event->setSelector("#{$this->getId()}");
        }
        return $event;
    }

    protected function getId(): string
    {
        return $this->getField()->getNormalizedCode() . '-' . $this->getEntity()->getId();
    }

    abstract public function build(): FormViewComponent;
}
