<?php

namespace Pars\Logic\Entity\Type\Definition;

use Pars\Logic\Entity\Entity;

class Type extends Entity
{
    public const OPTION_ALLOW_CHILDREN = 'allow_children';
    public const OPTION_ALLOW_EDIT_FIELDS = 'allow_fields';
    public const DATA_INFO = 'info';

    private TypeInfo $info;

    protected function init()
    {
        parent::init();
        $this->initDefaults();
        $this->changeInfo();
    }

    public function initDefaults()
    {
        $this->setAllowEditFields(self::TYPE_TYPE === $this->getCode());
        $this->getInfo()->addTextField('code');
        $this->getInfo()->addTextField('name');
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

    final public function getContext(): string
    {
        return self::CONTEXT_DEFINITION;
    }

    public function getGroup(): string
    {
        return self::GROUP_SCHEMA;
    }

    final public function isAllowChildren(): bool
    {
        return $this->hasOption(self::OPTION_ALLOW_CHILDREN);
    }

    final public function setAllowChildren(bool $state): self
    {
        $this->toggleOption(self::OPTION_ALLOW_CHILDREN, $state);
        return $this;
    }

    final public function isAllowEditFields(): bool
    {
        return $this->hasOption(self::OPTION_ALLOW_EDIT_FIELDS);
    }

    final public function setAllowEditFields(bool $state): self
    {
        $this->toggleOption(self::OPTION_ALLOW_EDIT_FIELDS, $state);
        return $this;
    }

    final public function getInfo(): TypeInfo
    {
        if (!isset($this->info)) {
            $this->info = new TypeInfo();
            $this->info->from($this->getDataArray()[self::DATA_INFO] ?? []);
        }
        return $this->info;
    }

    final public function changeInfo(): self
    {
        $this->replaceDataArray([self::DATA_INFO => $this->getInfo()]);
        return $this;
    }
}