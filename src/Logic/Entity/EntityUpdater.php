<?php

namespace Pars\Logic\Entity;

class EntityUpdater
{
    public function update()
    {
        $this->updateDefinition(Entity::TYPE_CONTEXT, Entity::CONTEXT_DEFINITION);
        $this->updateDefinition(Entity::TYPE_CONTEXT, Entity::CONTEXT_DATA);
    
        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_CONTEXT);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_STATE);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_LANGUAGE);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_COUNTRY);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_TYPE);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_DATA);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_DATA, Entity::TYPE_TEXT);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'text', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_DATA, Entity::TYPE_ARTICLE);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'text', $definition->getId());

        $definition = $this->updateDefinition(Entity::TYPE_DATA, Entity::TYPE_SITE);
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'text', $definition->getId());

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

    public function updateDefinition(string $type, string $code, string $parent = null)
    {
        $repo = new EntityRepository();
        $definition = new Entity();
        $definition->clear();
        if ($parent) {
            $definition->setParent($parent);
        }
        $definition->setCode($code);
        $definition->setType($type);
        $definition->setContext(Entity::CONTEXT_DEFINITION);

        if ($repo->exists($definition)) {
            $definition = $repo->find($definition)->current();
        } else {
            $definition = $repo->save($definition);
        }
        return $definition;
    }
}
