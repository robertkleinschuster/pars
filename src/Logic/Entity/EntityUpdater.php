<?php

namespace Pars\Logic\Entity;

class EntityUpdater
{
    public function update()
    {
        $this->updateDefinition(Entity::TYPE_CONTEXT, Entity::CONTEXT_DEFINITION, null, 'Schema');
        $this->updateDefinition(Entity::TYPE_CONTEXT, Entity::CONTEXT_DATA, null, 'Daten');

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_CONTEXT, null, 'Kontext');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId(), 'Bezeichnung');

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_STATE, null, 'Status');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId(), 'Bezeichnung');

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_LANGUAGE, null, 'Sprache');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId(), 'Bezeichnung');

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_COUNTRY, null, 'Land');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId(), 'Bezeichnung');

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_TYPE, null, 'Entität');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId(), 'Bezeichnung');

        $definition = $this->updateDefinition(Entity::TYPE_TYPE, Entity::TYPE_DATA, null, 'Daten');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'name', $definition->getId(), 'Bezeichnung');

        $definition = $this->updateDefinition(Entity::TYPE_DATA, Entity::TYPE_TEXT, null, 'Text');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'text', $definition->getId(), 'Textinhalt');

        $definition = $this->updateDefinition(Entity::TYPE_DATA, Entity::TYPE_ARTICLE, null, 'Artikel');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'text', $definition->getId(), 'Textinhalt');

        $definition = $this->updateDefinition(Entity::TYPE_DATA, Entity::TYPE_SITE, null, 'Seite');
        $this->updateDefinition($definition->getType(), 'code', $definition->getId());
        $this->updateDefinition($definition->getType(), 'text', $definition->getId(), 'Textinhalt');

        $this->updateDefinition(Entity::TYPE_STATE, Entity::STATE_ACTIVE, null, 'Aktiv');
        $this->updateDefinition(Entity::TYPE_STATE, Entity::STATE_INACTIVE, null, 'Inaktiv');

        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_DE, null, 'Deutsch');
        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_EN, null, 'Englisch');
        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_FR, null, 'Französisch');
        $this->updateDefinition(Entity::TYPE_LANGUAGE, Entity::LANGUAGE_IT, null, 'Italienisch');

        $this->updateDefinition(Entity::TYPE_COUNTRY, Entity::COUNTRY_AT, null, 'Österreich');
        $this->updateDefinition(Entity::TYPE_COUNTRY, Entity::COUNTRY_DE, null, 'Deutschland');
        $this->updateDefinition(Entity::TYPE_COUNTRY, Entity::COUNTRY_CH, null, 'Schweiz');
    }

    public function updateDefinition(string $type, string $code, string $parent = null, string $name = '')
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
            $definition->setName($name);
            $definition = $repo->save($definition);
        }
        return $definition;
    }
}
