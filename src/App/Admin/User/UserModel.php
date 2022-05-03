<?php

namespace Pars\App\Admin\User;

use Pars\Core\View\ViewModel;
use Pars\Logic\User\User;
use Pars\Logic\User\UserException;
use Pars\Logic\User\UserRepository;
use Traversable;

class UserModel extends ViewModel
{
    protected string $id;
    protected string $name;

    /**
     * @throws UserException
     */
    public function getIterator(): Traversable
    {
        $repo = new UserRepository();
        foreach ($repo->findAll() as $user) {
            yield (new static())->fromUser($user);
        }
    }

    /**
     * @param string $id
     * @return UserModel
     */
    public function setId(string $id): UserModel
    {
        $this->id = $id;
        return $this;
    }


    public function isList(): bool
    {
        if (isset($this->id)) {
            $repo = new UserRepository();
            $this->fromUser($repo->findById($this->id));
            return false;
        }
        return true;
    }

    private function fromUser(User $user): self
    {
        $this->set('id', $user->getId());
        $this->set('name', $user->getName());
        return $this;
    }
}