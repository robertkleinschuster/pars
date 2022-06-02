<?php

namespace Pars\Logic\Entity\Type\Definition;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\Info\EntityField;

class Type extends Entity
{
    public const OPTION_ALLOW_CHILDREN = 'allow_children';
    public const OPTION_ALLOW_EDIT_FIELDS = 'allow_edit_fields';
    public const OPTION_ALLOW_OWN_FIELDS = 'allow_own_fields';


    protected function init()
    {
        parent::init();
        $this->initDefaults();
    }

    public function initDefaults()
    {
        $this->getInfo()->addTextField('code')
            ->getViewOptions()->enable(EntityField::VIEW_OPTION_OVERVIEW);
        $this->getInfo()->addTextField('name')
            ->getViewOptions()->enable(EntityField::VIEW_OPTION_OVERVIEW);

        if (self::TYPE_TYPE === $this->getCode()) {
            $this->setAllowEditFields(true);

            $this->getInfo()->addCheckboxField('options[allow_edit_fields]', __('entity.type.option.allow_edit_fields'));
            $this->getInfo()->addCheckboxField('options[allow_own_fields]', __('entity.type.option.allow_own_fields'));
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
}