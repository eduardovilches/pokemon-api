<?php

namespace App\Strategy\Register;

use App\Entity\User;
/**
 * Interface RegisterUserInterface
 * Class Strategy used for new Register Role Professor
 */
class RegisterUserProfessor implements RegisterUserInterface
{
    public function register(User $user): void
    {
        var_dump("entro");
        //$user->setRoles(['ROLE_PROFESSOR']);
    }
}
