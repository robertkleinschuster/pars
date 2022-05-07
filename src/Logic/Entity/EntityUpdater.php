<?php

namespace Pars\Logic\Entity;

class EntityUpdater
{
    public function addField(Entity $entity, string $code, string $name)
    {
        $field = clone $entity;
        $field->setId('');
        $field->setParent($entity->getId());
        $field->setCode($code);
        $field->setName($name);
        return $this->save($field);
    }

    public function addSelectField(Entity $entity, string $code, string $name)
    {
        $field = clone $entity;
        $field->setId('');
        $field->setParent($entity->getId());
        $field->setCode($code);
        $field->setName($name);
        $field->setDataArray([
            'select' => [
                Entity::TYPE_TYPE => $code,
                Entity::TYPE_CONTEXT => Entity::CONTEXT_ENTRY,
            ]
        ]);
        return $this->save($field);
    }


    public function updateType()
    {
        // Type
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_TYPE);
        $type->setName('Typ');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_SCHEMA);
        $type->setContext(Entity::CONTEXT_DEFINITION);

        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');

        $typeField = clone $type;
        $typeField->setId('');
        $typeField->setParent($type->getId());
        $typeField->setCode('select[type]');
        $typeField->setName('Auswahl von');
        $typeField->setDataArray([
            'select' => [
                Entity::TYPE_TYPE => Entity::TYPE_TYPE,
                Entity::TYPE_CONTEXT => Entity::CONTEXT_ENTRY,
            ]
        ]);
        $this->save($typeField);

        // Context
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_CONTEXT);
        $type->setName('Kontext');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_SCHEMA);
        $type->setContext(Entity::CONTEXT_ENTRY);
        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');

        // Group
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_GROUP);
        $type->setName('Gruppe');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_SCHEMA);
        $type->setContext(Entity::CONTEXT_ENTRY);
        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');

        // State
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_STATE);
        $type->setName('Status');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_SYSTEM);
        $type->setContext(Entity::CONTEXT_ENTRY);
        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');

        // Language
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_LANGUAGE);
        $type->setName('Sprache');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_SYSTEM);
        $type->setContext(Entity::CONTEXT_ENTRY);
        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');

        // Country
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_COUNTRY);
        $type->setName('Land');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_SYSTEM);
        $type->setContext(Entity::CONTEXT_ENTRY);
        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');

        // Text
        $type = new Entity();
        $type->clear();
        $type->setCode(Entity::TYPE_TEXT);
        $type->setName('Text');
        $type->setType(Entity::TYPE_TYPE);
        $type->setGroup(Entity::GROUP_CONTENT);
        $type->setContext(Entity::CONTEXT_ENTRY);
        $type = $this->save($type);
        $this->addField($type, 'code', 'Code');
        $this->addField($type, 'name', 'Name');
        $this->addField($type, 'text', 'Text');
        $this->addSelectField($type, 'state', 'Status');
        $this->addSelectField($type, 'language', 'Sprache');
        $this->addSelectField($type, 'country', 'Land');
    }


    public function updateContext()
    {
        // Definition
        $context = new Entity();
        $context->clear();
        $context->setCode(Entity::CONTEXT_DEFINITION);
        $context->setName('Definition');
        $context->setType(Entity::TYPE_CONTEXT);
        $context->setGroup(Entity::GROUP_SYSTEM);
        $context->setContext(Entity::CONTEXT_ENTRY);
        $this->save($context);

        // Entry
        $context = new Entity();
        $context->clear();
        $context->setCode(Entity::CONTEXT_ENTRY);
        $context->setName('Eintrag');
        $context->setType(Entity::TYPE_CONTEXT);
        $context->setGroup(Entity::GROUP_SYSTEM);
        $context->setContext(Entity::CONTEXT_ENTRY);
        $this->save($context);
    }

    public function updateState()
    {
        // Active
        $state = new Entity();
        $state->clear();
        $state->setCode(Entity::STATE_ACTIVE);
        $state->setName('Aktiviert');
        $state->setType(Entity::TYPE_STATE);
        $state->setGroup(Entity::GROUP_SYSTEM);
        $state->setContext(Entity::CONTEXT_ENTRY);
        $this->save($state);

        // Inactive
        $state = new Entity();
        $state->clear();
        $state->setCode(Entity::STATE_INACTIVE);
        $state->setName('Deaktiviert');
        $state->setType(Entity::TYPE_STATE);
        $state->setGroup(Entity::GROUP_SYSTEM);
        $state->setContext(Entity::CONTEXT_ENTRY);
        $this->save($state);
    }

    public function updateGroup()
    {
        // Content
        $group = new Entity();
        $group->clear();
        $group->setCode(Entity::GROUP_CONTENT);
        $group->setName('Inhalt');
        $group->setType(Entity::TYPE_GROUP);
        $group->setGroup(Entity::GROUP_SCHEMA);
        $group->setContext(Entity::CONTEXT_ENTRY);
        $this->save($group);

        // System
        $group = new Entity();
        $group->clear();
        $group->setCode(Entity::GROUP_SYSTEM);
        $group->setName('System');
        $group->setType(Entity::TYPE_GROUP);
        $group->setGroup(Entity::GROUP_SCHEMA);
        $group->setContext(Entity::CONTEXT_ENTRY);
        $this->save($group);

        // Schema
        $group = new Entity();
        $group->clear();
        $group->setCode(Entity::GROUP_SCHEMA);
        $group->setName('Schema');
        $group->setType(Entity::TYPE_GROUP);
        $group->setGroup(Entity::GROUP_SCHEMA);
        $group->setContext(Entity::CONTEXT_ENTRY);
        $this->save($group);
    }


    public function updateLanguage()
    {
        // DE
        $language = new Entity();
        $language->clear();
        $language->setCode(Entity::LANGUAGE_DE);
        $language->setName('Deutsch');
        $language->setType(Entity::TYPE_LANGUAGE);
        $language->setGroup(Entity::GROUP_SYSTEM);
        $language->setContext(Entity::CONTEXT_ENTRY);
        $this->save($language);

        // IT
        $language = new Entity();
        $language->clear();
        $language->setCode(Entity::LANGUAGE_IT);
        $language->setName('Italienisch');
        $language->setType(Entity::TYPE_LANGUAGE);
        $language->setGroup(Entity::GROUP_SYSTEM);
        $language->setContext(Entity::CONTEXT_ENTRY);
        $this->save($language);

        // FR
        $language = new Entity();
        $language->clear();
        $language->setCode(Entity::LANGUAGE_FR);
        $language->setName('Französisch');
        $language->setType(Entity::TYPE_LANGUAGE);
        $language->setGroup(Entity::GROUP_SYSTEM);
        $language->setContext(Entity::CONTEXT_ENTRY);
        $this->save($language);

        // EN
        $language = new Entity();
        $language->clear();
        $language->setCode(Entity::LANGUAGE_EN);
        $language->setName('Englisch');
        $language->setType(Entity::TYPE_LANGUAGE);
        $language->setGroup(Entity::GROUP_SYSTEM);
        $language->setContext(Entity::CONTEXT_ENTRY);
        $this->save($language);
    }

    public function updateCountry()
    {
        // AT
        $country = new Entity();
        $country->clear();
        $country->setCode(Entity::COUNTRY_AT);
        $country->setName('Österreich');
        $country->setType(Entity::TYPE_COUNTRY);
        $country->setGroup(Entity::GROUP_SYSTEM);
        $country->setContext(Entity::CONTEXT_ENTRY);
        $this->save($country);

        // DE
        $country = new Entity();
        $country->clear();
        $country->setCode(Entity::COUNTRY_DE);
        $country->setName('Deutschland');
        $country->setType(Entity::TYPE_COUNTRY);
        $country->setGroup(Entity::GROUP_SYSTEM);
        $country->setContext(Entity::CONTEXT_ENTRY);
        $this->save($country);


        // CH
        $country = new Entity();
        $country->clear();
        $country->setCode(Entity::COUNTRY_CH);
        $country->setName('Schweiz');
        $country->setType(Entity::TYPE_COUNTRY);
        $country->setGroup(Entity::GROUP_SYSTEM);
        $country->setContext(Entity::CONTEXT_ENTRY);
        $this->save($country);
    }

    public function update()
    {
        $this->updateContext();
        $this->updateGroup();
        $this->updateState();
        $this->updateType();
        $this->updateLanguage();
        $this->updateCountry();
    }


    public function save(Entity $entity)
    {
        $repo = new EntityRepository();
        $name = $entity->getName();
        $entity->setName('');

        if ($repo->exists($entity)) {
            $entity = $repo->find($entity)->current();
        } else {
            $entity->setName($name);
            $entity = $repo->save($entity);
        }

        return $entity;
    }
}
