<?php

namespace App\Strategy\Register;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Strategy used for new Register Role Trainer
 */
class RegisterUserTrainer implements RegisterUserInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly UserPasswordHasherInterface $passwordHasher
    ){}

    public function register(User $entity): void
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException((string) $errors, 400);
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $entity,
            $entity->getPassword()
        );

        $entity->setPassword($hashedPassword);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}