<?php

namespace Pars\Logic\User;

use Generator;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(config('db.dsn'), config('db.username'), config('db.password'));
    }

    /**
     * @return Generator
     * @throws UserException
     */
    public function findAll(): Generator
    {
        $query = 'SELECT * FROM User';
        $stmt = $this->pdo->prepare($query);
        if ($stmt->execute()) {
            while ($user = $stmt->fetchObject(User::class)) {
                yield $user;
            }
        } else {
            throw new UserException('Unable to load users');
        }
    }

    /**
     * @param string $id
     * @return User
     * @throws UserException
     */
    public function findById(string $id): User
    {
        $exception = new UserException('Unable to load user with id: ' . $id);
        $query = 'SELECT * FROM User WHERE User_ID = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('id', $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject(User::class) ?: throw $exception;
        }
        throw $exception;
    }

    /**
     * @param string $name
     * @return User
     * @throws UserException
     */
    public function findByName(string $name): User
    {
        $query = 'SELECT * FROM User WHERE User_Name = :name';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('name', $name);
        if ($stmt->execute()) {
            return $stmt->fetchObject(User::class);
        }
        throw new UserException('Unable to load user');
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    public function save(User $user): User
    {
        if ($user->getId()) {
            return $this->update($user);
        } else {
            return $this->insert($user);
        }
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    private function update(User $user): User
    {
        if ($user->getId()) {
            $query = 'UPDATE User
SET User_Name=:name, User_Password=:password, User_Data=:data
WHERE User_ID = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue('name', $user->getName());
            $stmt->bindValue('password', $user->getPassword());
            $stmt->bindValue('data', $user->getData());
            $stmt->bindValue('id', $user->getId());
            if ($stmt->execute()) {
                return $user;
            }
        }

        if ($user->getId()) {
            throw new UserException('Unable to save user with id: ' . $user->getId());
        }
        throw new UserException('Unable to save user');
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    private function insert(User $user): User
    {
        $query = 'INSERT INTO User (User_Name, User_Password, User_Data)
VALUES (:name, :password, :data) RETURNING *';
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue('name', $user->getName());
        $stmt->bindValue('password', $user->getPassword());
        $stmt->bindValue('data', $user->getData());

        if ($stmt->execute()) {
            return $stmt->fetchObject(User::class);
        }

        throw new UserException('Unable to save user');
    }
}