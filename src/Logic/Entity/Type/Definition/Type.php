<?php

namespace Pars\Logic\Entity\Type\Definition;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\Info\EntityField;

class Type extends Entity
{
    public const OPTION_ALLOW_CHILDREN = 'allow_children';
    public const OPTION_ALLOW_EDIT_FIELDS = 'allow_edit_fields';
    public const OPTION_ALLOW_OWN_FIELDS = 'allow_own_fields';

    public const DATA_CHILD_TYPE = 'child_type';

    protected function init()
    {
        parent::init();
        $this->initDefaults();
        if (empty($this->getChildType())) {
            $this->getDataObject()->offsetUnset(self::DATA_CHILD_TYPE);
        }
    }

    public function initDefaults()
    {
        if (self::TYPE_TYPE === $this->getCode()) {
            $this->getInfo()->addTextField('code')
                ->setOrder(0)
                ->getViewOptions()->enable(EntityField::VIEW_OPTION_OVERVIEW);
            $this->getInfo()->addTextField('name')
                ->setOrder(0)
                ->getViewOptions()->enable(EntityField::VIEW_OPTION_OVERVIEW);

            $this->setAllowEditFields(true);

            $this->getInfo()->addOptionField(
                self::OPTION_ALLOW_EDIT_FIELDS,
                __('entity.type.option.allow_edit_fields')
            );
            $this->getInfo()->addOptionField(
                self::OPTION_ALLOW_OWN_FIELDS,
                __('entity.type.option.allow_own_fields')
            );
            $this->getInfo()->addOptionField(
                self::OPTION_ALLOW_CHILDREN,
                __('entity.type.option.allow_children')
            );
            $this->getInfo()->addSelectField(self::DATA_CHILD_TYPE, __('entity.type.option.child_type'), 'type');
        }
    }

    public function getCode(): string
    {
        if (empty($this->Entity_Code)) {
            return self::TYPE_TYPE;
        }
        return parent::getCode();
    }

    final public function getType(): string
    {
        return self::TYPE_TYPE;
    }

    final public function isAllowChildren(): bool
    {
        return $this->getOptionsObject()->has(self::OPTION_ALLOW_CHILDREN);
    }

    final public function setAllowChildren(bool $state): self
    {
        $this->getOptionsObject()->set(self::OPTION_ALLOW_CHILDREN, $state);
        return $this;
    }

    final public function isAllowEditFields(): bool
    {
        return $this->getOptionsObject()->has(self::OPTION_ALLOW_EDIT_FIELDS);
    }

    final public function setAllowEditFields(bool $state): self
    {
        $this->getOptionsObject()->set(self::OPTION_ALLOW_EDIT_FIELDS, $state);
        return $this;
    }

    final public function isAllowOwnFields(): bool
    {
        return $this->getOptionsObject()->has(self::OPTION_ALLOW_OWN_FIELDS);
    }

    final public function setAllowOwnFields(bool $state): self
    {
        $this->getOptionsObject()->set(self::OPTION_ALLOW_OWN_FIELDS, $state);
        return $this;
    }

    final public function getChildType(): string
    {
        return $this->find(self::DATA_CHILD_TYPE, $this->getCode());
    }
}