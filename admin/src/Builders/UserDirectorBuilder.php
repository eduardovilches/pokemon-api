<?php

namespace App\Builders;

use App\Builders\ProfessorBuilder;
use App\Builders\TrainerBuilder;
use App\Entity\User;

class UserDirectorBuilder
{
    public function build($data, $type): User
    {
        var_dump($data);exit();
        $builder = NULL;
        switch (strtoupper($type)) {
            case 'PROFESSOR':
                $builder = new ProfessorBuilder();
                break;
            case 'TRAINER':
                $builder = new TrainerBuilder();

                break;
            default:
                throw new \Exception("No existe tipo de build: $type");
        }

        $builder->setUsername($data['username'])
        ->setPassword($data['password'])
        ->setRoles($data['roles']);

        return $builder->getUser();
    }
}
