<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function findRandomPokemon($user)
    {   
        return $this->createQueryBuilder('p') // Alias para la entidad Pokemon
        
        ->where('p.trainer IS NULL') 
        
        ->orderBy('p.id', 'ASC') 
        ->setMaxResults(1)
        ->getQuery()
        ->getArrayResult();
    }
}
