<?php

namespace Pars\Logic\Entity;

class EntityUpdater
{
    public function update()
    {
        $this->updateDefinition(Entity::TYPE_CONTEXT, Entity::CONTEXT_DEFINITION);
        $this->updateDefinition(Entity::TYPE_CONTEXT, Entity::CONTEXT_DATA);

        $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_CONTEXT);
        $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_STATE);
        $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_LANGUAGE);
        $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_COUNTRY);
        $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_TYPE);
        $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_DATA);

        $this->updateDefinition(Entity::TYPE_STATE, Entity::STATE_ACTIVE);
        $this->updateDefinition(Entity::TYPE_STATE, Entity::STATE_INACTIVE);

        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_DE);
        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_EN);
        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_FR);
        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_IT);

        $this->updateDefinition(Entity::TYPE_COUNTRY, Entity::COUNTRY_AT);
        $this->updateDefinition(Entity::TYPE_COUNTRY, Entity::COUNTRY_CH);
        $this->updateDefinition(Entity::TYPE_COUNTRY, Entity::COUNTRY_DE);
    }

    public function updateDefinition(string $type, string $code, string $name = '')
    {
        $repo = new EntityRepository();
        $definition = new Entity();
        $definition->clear();
        $definition->setName($name);
        $definition->setCode($code);
        $definition->setType($type);
        $definition->setContext('definition');

        if (!$repo->exists($definition)) {
            $repo->save($definition);
        }
    }
}