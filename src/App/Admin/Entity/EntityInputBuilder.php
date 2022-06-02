<?php

namespace Pars\App\Admin\Entity;

use Pars\App\Admin\Entity\InputBuilder\BaseBuilder;
use Pars\App\Admin\Entity\InputBuilder\BuilderFactory;
use Pars\Core\View\FormViewComponent;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\Info\EntityField;

class EntityInputBuilder
{
    private BaseBuilder $builder;

    final public function __construct(Entity $entity, EntityField $field)
    {
        $this->builder = BuilderFactory::create($entity, $field);
    }

    public function build(): FormViewComponent
    {
        return $this->builder->build();
    }
}
