<?php

namespace App\Strategy\Register;

use App\Entity\User;

interface RegisterUserInterface
{
    public function register(User $user): void;
}
