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
        $this->getInfo()->addSelectField(MenuEntry::DATA_PARAMETER . '[type]', 'Type', 'type')
            ->setChapter('Parameter')
            ->setGroup('');
    }
}