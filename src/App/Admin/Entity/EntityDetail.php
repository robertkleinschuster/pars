<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Input\Input;
use Pars\Core\View\ViewException;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\Info\EntityField;

/**
 * @method EntityModel getModel()
 */
class EntityDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new EntityModel();
        $this->setHeadingKey('{type:nameFallback}: {nameFallback}');
    }

    public function addInput(string $key, string $label, string $chapter = null, string $group = null): Input
    {
        $input = parent::addInput($key, $label, $chapter, $group);
        $input->model = $this->model;
        return $input;
    }

    /**
     * @throws EntityException
     */
    public function setId(string $id): static
    {
        $model = $this->getModel();
        $model->setId($id);
        $entity = $model->getEntity();
        foreach ($model->getFields() as $field) {
            if (empty($field->getCode()) && !$field->getViewOptions()->has(EntityField::VIEW_OPTION_DETAIL)) {
                continue;
            }
            $builder = new EntityInputBuilder($entity, $field);
            $input = $builder->build();
            if (null === $model->get($field->getCode()) || '' === $model->get($field->getCode())) {
                $model->set($field->getCode(), $field->getDefaultValue());
            }
            $this->push($input->withModel($model), $field->getChapter(), $field->getGroup());
        }

        return $this;
    }

    public function getId(): string
    {
        return 'entity-' . $this->getModel()->getId();
    }
}
