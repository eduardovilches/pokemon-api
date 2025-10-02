<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PokemonController extends AbstractController
{
    #[Route('/pokemon/random', name: 'pokemon_random', methods: ['GET'])]
    public function random(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        $pokemonRepository = $entityManager->getRepository(\App\Entity\Pokemon::class);
        $randomPokemon = $pokemonRepository->findRandomPokemon($user);


        return $this->json([
            'pokemon' => $randomPokemon
        ]);
    }

    #[Route('/pokemon/{id}/catch', name: 'pokemon_catch', methods: ['POST'])]
    public function catch(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'No autenticado'], 401);
        }

        $pokemonRepository = $entityManager->getRepository(\App\Entity\Pokemon::class);
        $pokemon = $pokemonRepository->find($id);


        if (!$pokemon) {
            return $this->json(['error' => 'Pokémon no encontrado'], 404);
        }

        // Verifica si el Pokémon ya tiene entrenador
        if ($pokemon->getTrainer() !== null) {
            return $this->json(['error' => 'Este Pokémon ya ha sido capturado'], 409);
        }

        // Asigna el Pokémon al usuario actual
        $pokemon->setTrainer($user);

        $entityManager->persist($pokemon);
        $entityManager->flush();

        return $this->json([
            'message' => '¡Pokémon capturado exitosamente!',
            'pokemon' => $pokemon
        ], 200, [], ['groups' => 'team:read']);
    }

    #[Route('/pokemon/{pokemon_id}/moves', name: 'pokemon_add_move', methods: ['POST'])]
    public function addMoveToPokemon(
        int $pokemon_id,
        EntityManagerInterface $entityManager,
        \Symfony\Component\HttpFoundation\Request $request
    ): JsonResponse {

        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'No autenticado'], 401);
        }

        $pokemonRepository = $entityManager->getRepository(\App\Entity\Pokemon::class);
        $pokemon = $pokemonRepository->find($pokemon_id);

        if (!$pokemon) {
            return $this->json(['error' => 'Pokémon no encontrado'], 404);
        }

        // Verifica si el usuario es el entrenador del Pokémon
        if ($pokemon->getTrainer() === null || $pokemon->getTrainer()->getId() !== $user->getId()) {
            return $this->json(['error' => 'No tienes permiso para modificar este Pokémon'], 403);
        }

        $data = json_decode($request->getContent(), true);
        if (!isset($data['move_id'])) {
            return $this->json(['error' => 'Falta el parámetro move_id'], 400);
        }

        $moveId = $data['move_id'];
        $move = $entityManager->getRepository(\App\Entity\Move::class)->find($moveId);

        if (!$move) {
            return $this->json(['error' => 'Movimiento no encontrado'], 404);
        }

        // Añadir el movimiento al Pokémon
        $pokemon->addMove($move);

        $entityManager->persist($pokemon);
        $entityManager->flush();

        return $this->json([
            'message' => 'Movimiento añadido exitosamente al Pokémon',
            'pokemon_id' => $pokemon->getId(),
            'move_id' => $move->getId()
        ], 200);
    }
}
