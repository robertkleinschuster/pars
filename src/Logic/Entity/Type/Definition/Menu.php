<?php

namespace Pars\Logic\Entity\Type\Definition;

use Pars\Logic\Entity\Type\Entry\Menu as MenuEntry;

class Menu extends Type
{
    public function getCode(): string
    {
        return self::TYPE_MENU;
    }

    public function initDefaults()
    {
        parent::initDefaults();
        $this->setAllowChildren(true);
        $this->getInfo()->addSelectField(MenuEntry::DATA_PARAMS . '[type]', 'Type', 'type')
            ->setChapter('Parameter')
            ->setGroup('');
        $this->getInfo()->addSelectField(MenuEntry::DATA_PARAMS . '[context]', 'Context', 'context')
            ->setChapter('Parameter')
            ->setGroup('');
        $this->getInfo()->addSelectField(MenuEntry::DATA_PARAMS . '[group]', 'Group', 'group')
            ->setChapter('Parameter')
            ->setGroup('');
    }
}