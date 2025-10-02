<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    #[Route('/pokemon/random', name: 'pokemon_random', methods: ['GET'])]
    public function random(): JsonResponse
    {
        $pokemons = [
            'Bulbasaur',
            'Charmander',
            'Squirtle',
            'Pikachu',
            'Eevee',
            'Jigglypuff',
            'Meowth',
            'Psyduck',
            'Snorlax',
            'Gengar'
        ];

        $randomPokemon = $pokemons[array_rand($pokemons)];

        return $this->json([
            'pokemon' => $randomPokemon
        ]);
    }
}
