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
     * @throws ViewException
     * @throws EntityException
     */
    public function setId(string $id): static
    {
        $this->getModel()->setId($id);

        foreach ($this->getModel()->getFields() as $field) {
            if (empty($field->getCode()) && !$field->getViewOptions()->has(EntityField::VIEW_OPTION_DETAIL)) {
                continue;
            }
            $builder = new EntityInputBuilder($field);
            $input = $builder->build();
            $value = $this->getValue($field->getCode());
            $model = $this->getModel();

            if ($value) {
                $model->setValue($value);
            }

            $this->push($input->withModel($model), $field->getChapter(), $field->getGroup());
        }

        return $this;
    }
}
