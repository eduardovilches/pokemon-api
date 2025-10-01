<?php
namespace App\Strategy\Register;
use App\Entity\User;

class RegisterUserTrainer implements RegisterUserInterface
{
    public function register(User $user): void
    {
        //$user->setRoles(['ROLE_TRAINER']);
    }
}