<?php

namespace ParsTest\Logic\Entity;

use Pars\Logic\Entity\Entity;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testFind()
    {
        $entity = new Entity();
        $entity->getInfo()->addSelectField('code', 'Code', 'group');
        $this->assertEquals('group', $entity->getDataObject()->find('info[fields][code][reference][type]'));
    }
}
