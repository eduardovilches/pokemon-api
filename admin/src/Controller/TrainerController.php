<?php
// src/Controller/TrainerApiController.php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pokemon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class TrainerController extends AbstractController
{
    // Usa el param converter de Symfony para obtener la entidad User automáticamente
    #[Route('/trainers/{id}/team', name: 'api_trainer_team', methods: ['GET'])]
    
    public function getTrainerTeam(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(
                ['message' => 'Entrenador no encontrado'],
                Response::HTTP_NOT_FOUND
            );
        }

        // Si el usuario autenticado tiene el rol ROLE_TRAINER, solo puede ver su propio equipo
        $currentUser = $this->getUser();
        if ($currentUser && in_array('ROLE_TRAINER', $currentUser->getRoles())) {
            if ($currentUser->getId() !== $user->getId()) {
                return $this->json(
                    ['message' => 'No tienes permiso para ver el equipo de este entrenador'],
                    Response::HTTP_FORBIDDEN
                );
            }
        }


        // Obtener el equipo del entrenador (Pokémon asociados)
        $pokemons = $entityManager->getRepository(Pokemon::class)
        ->findPokemonsPerUser($user);
        
		return $this->json(
			['team' => $pokemons],
            Response::HTTP_OK
        );

        } catch(\Exception $e){

            return $this->json(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
}