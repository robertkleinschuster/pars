<?php

namespace Pars\Logic\Entity;

use Generator;
use PDO;
use PDOStatement;

class EntityRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(config('db.dsn'), config('db.username'), config('db.password'));
    }

    public function delete(Entity $entity): bool
    {
        $query = 'DELETE FROM Entity WHERE 1=1';

        $query = $this->buildCondition($entity, $query);

        $stmt = $this->prepareStmt($entity, $query);
        return $stmt->execute();
    }

    /**
     * @param string $id
     * @param string $class
     * @return Entity
     * @throws EntityException
     */
    public function findById(string $id, string $class = Entity::class): Entity
    {
        $exception = new EntityException('Unable to load Entity with id: ' . $id);
        $query = 'SELECT * FROM Entity WHERE Entity_ID = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id', $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject($class) ?: throw $exception;
        }
        throw $exception;
    }

    /**
     * @param string $class
     * @return Generator&Entity[]
     * @throws EntityException
     */
    public function findByIdList(array $id, string $class = Entity::class): Generator
    {
        if (!count($id)) {
            return;
        }
        $in = str_repeat('?,', count($id) - 1) . '?';

        $query = "SELECT * FROM Entity WHERE Entity_ID IN ($in)";

        $stmt = $this->pdo->prepare($query);

        if ($stmt->execute($id)) {
            while ($entity = $stmt->fetchObject($class)) {
                yield $entity;
            }
        } else {
            throw new EntityException('Unable to load Entities');
        }
    }

    /**
     * @param string $class
     * @return Generator&Entity[]
     * @throws EntityException
     */
    public function findByParentIdList(array $id, string $class = Entity::class): Generator
    {
        if (!count($id)) {
            return;
        }
        $in = str_repeat('?,', count($id) - 1) . '?';

        $query = "SELECT * FROM Entity WHERE Entity_ID_Parent IN ($in)";

        $stmt = $this->pdo->prepare($query);

        if ($stmt->execute($id)) {
            while ($entity = $stmt->fetchObject($class)) {
                yield $entity;
            }
        } else {
            throw new EntityException('Unable to load Entities');
        }
    }

    /**
     * @param Entity $entity
     * @param string|null $class
     * @return Generator&Entity[]
     * @throws EntityException
     */
    public function find(Entity $entity, string $class = null): Generator
    {
        if (null === $class) {
            $class = get_class($entity);
        }
        $query = 'SELECT * FROM Entity WHERE 1=1';

        $query = $this->buildCondition($entity, $query);

        $query .= '  ORDER BY Entity_Type, Entity_Order';

        $stmt = $this->prepareStmt($entity, $query);

        if ($stmt->execute()) {
            while ($entity = $stmt->fetchObject($class)) {
                yield $entity;
            }
        } else {
            throw new EntityException('Unable to load Entities');
        }
    }

    public function exists(Entity $entity): bool
    {
        $condition = $this->buildCondition($entity, '');

        $query = "SELECT IF(EXISTS(SELECT Entity_ID FROM Entity WHERE 1=1 $condition), 1, 0)";

        $stmt = $this->prepareStmt($entity, $query);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            throw new EntityException('Unable to load Entities');
        }
    }

    /**
     * @param Entity $entity
     * @return Entity
     * @throws EntityException
     */
    public function save(Entity $entity): Entity
    {
        if ($entity->getId()) {
            return $this->update($entity);
        } else {
            return $this->insert($entity);
        }
    }

    /**
     * @param Entity $entity
     * @return Entity
     * @throws EntityException
     */
    private function update(Entity $entity): Entity
    {
        if ($entity->getId()) {
            $query = 'UPDATE Entity
SET
    Entity_Type=:type,
    Entity_State=:state,
    Entity_Context=:context,
    Entity_Group=:group,
    Entity_Language=:language,
    Entity_Country=:country,
    Entity_Code=:code,
    Entity_Name=:name,
    Entity_Data=:data,
    Entity_Options=:options
WHERE Entity_ID = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue('type', $entity->getType());
            $stmt->bindValue('state', $entity->getState());
            $stmt->bindValue('context', $entity->getContext());
            $stmt->bindValue('group', $entity->getGroup());
            $stmt->bindValue('language', $entity->getLanguage());
            $stmt->bindValue('country', $entity->getCountry());
            $stmt->bindValue('code', $entity->getCode());
            $stmt->bindValue('name', $entity->getName());
            $stmt->bindValue('data', $entity->getData());
            $stmt->bindValue('options', $entity->getOptions());
            $stmt->bindValue('id', $entity->getId());
            if ($stmt->execute()) {
                return $this->findById($entity->getId(), get_class($entity));
            }
        }

        if ($entity->getId()) {
            throw new EntityException('Unable to save Entity with id: ' . $entity->getId());
        }
        throw new EntityException('Unable to save Entity');
    }

    /**
     * @param Entity $entity
     * @return Entity
     * @throws EntityException
     */
    private function insert(Entity $entity): Entity
    {
        $query = 'INSERT INTO Entity (
                    Entity_ID_Parent,
                    Entity_ID_Template,
                    Entity_Type,
                    Entity_State,
                    Entity_Context,
                    Entity_Group,
                    Entity_Language,
                    Entity_Country,
                    Entity_Code,
                    Entity_Name,
                    Entity_Data,
                    Entity_Options
) VALUES (
        :parent,
        :template,
        :type,
        :state,
        :context,
        :group,
        :language,
        :country,
        :code,
        :name,
        :data,
        :options
        ) RETURNING *';

        $stmt = $this->pdo->prepare($query);

        if ($entity->getParent()) {
            $stmt->bindValue('parent', $entity->getParent());
        } else {
            $stmt->bindValue('parent', null, PDO::PARAM_NULL);
        }

        if ($entity->getTemplate()) {
            $stmt->bindValue('template', $entity->getTemplate());
        } else {
            $stmt->bindValue('template', null, PDO::PARAM_NULL);
        }

        $stmt->bindValue('type', $entity->getType());
        $stmt->bindValue('state', $entity->getState());
        $stmt->bindValue('context', $entity->getContext());
        $stmt->bindValue('group', $entity->getGroup());
        $stmt->bindValue('language', $entity->getLanguage());
        $stmt->bindValue('country', $entity->getCountry());
        $stmt->bindValue('code', $entity->getCode());
        $stmt->bindValue('name', $entity->getName());
        $stmt->bindValue('data', $entity->getData());
        $stmt->bindValue('options', $entity->getOptions());

        if ($stmt->execute()) {
            return $stmt->fetchObject(get_class($entity));
        }

        throw new EntityException('Unable to save Entity');
    }

    /**
     * @param Entity $entity
     * @param string $query
     * @return string
     */
    private function buildCondition(Entity $entity, string $query): string
    {
        if ($entity->getId()) {
            $query .= ' AND Entity_ID = :id';
        }

        if ($entity->getParent()) {
            $query .= ' AND Entity_ID_Parent = :parent';
        } else {
            $query .= ' AND Entity_ID_Parent IS NULL';
        }

        if ($entity->getTemplate()) {
            $query .= ' AND Entity_ID_Template = :template';
        } else {
            $query .= ' AND Entity_ID_Template IS NULL';
        }

        if ($entity->getType()) {
            $query .= ' AND Entity_Type = :type';
        }

        if ($entity->getState()) {
            $query .= ' AND Entity_State = :state';
        }

        if ($entity->getContext()) {
            $query .= ' AND Entity_Context = :context';
        }

        if ($entity->getGroup()) {
            $query .= ' AND Entity_Group = :group';
        }

        if ($entity->getLanguage()) {
            $query .= ' AND Entity_Language = :language';
        }

        if ($entity->getCountry()) {
            $query .= ' AND Entity_Country = :country';
        }

        if ($entity->getCode()) {
            $query .= ' AND Entity_Code = :code';
        }

        if ($entity->getName()) {
            $query .= ' AND Entity_Name = :name';
        }

        return $query;
    }

    /**
     * @param Entity $entity
     * @param string $query
     * @return false|PDOStatement
     */
    private function prepareStmt(Entity $entity, string $query): PDOStatement|false
    {
        $stmt = $this->pdo->prepare($query);

        if ($entity->getId()) {
            $stmt->bindValue('id', $entity->getId());
        }
        if ($entity->getParent()) {
            $stmt->bindValue('parent', $entity->getParent());
        }
        if ($entity->getTemplate()) {
            $stmt->bindValue('template', $entity->getTemplate());
        }
        if ($entity->getType()) {
            $stmt->bindValue('type', $entity->getType());
        }
        if ($entity->getState()) {
            $stmt->bindValue('state', $entity->getState());
        }
        if ($entity->getContext()) {
            $stmt->bindValue('context', $entity->getContext());
        }
        if ($entity->getGroup()) {
            $stmt->bindValue('group', $entity->getGroup());
        }
        if ($entity->getLanguage()) {
            $stmt->bindValue('language', $entity->getLanguage());
        }
        if ($entity->getCountry()) {
            $stmt->bindValue('country', $entity->getCountry());
        }
        if ($entity->getCode()) {
            $stmt->bindValue('code', $entity->getCode());
        }
        if ($entity->getName()) {
            $stmt->bindValue('name', $entity->getName());
        }
        return $stmt;
    }
}
