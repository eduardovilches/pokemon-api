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
}
