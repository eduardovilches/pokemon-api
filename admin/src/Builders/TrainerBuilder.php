<?php

namespace App\Builders;

use App\Entity\User;

class TrainerBuilder
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function setUsername(string $username): self
    {
        $this->user->setUsername($username);
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->user->setPassword($password);
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->user->setRoles($roles);
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
