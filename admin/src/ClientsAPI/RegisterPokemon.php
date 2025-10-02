<?php
namespace App\ClientsAPI;

use App\ClientsAPI\ClientPokeAPI;
use App\Builders\Pokemon\BuilderPokemon;
use Doctrine\ORM\EntityManagerInterface;

/**Class Register pokemon used for responsabilty Register Pokemon
 * 
 */
class RegisterPokemon
{
    public function __construct(
        private readonly ClientPokeAPI $pokeApi,
        private readonly EntityManagerInterface $entityManager

    ){}

    public function save($pokemons)
    {
        $pokemonItems = $this->saveData($pokemons['results']);
        $this->saveTypes();
    }

    /**
     * Create data for each pokemon stats
     */
    private function saveData($pokemons)
    {
        if(empty($pokemons)){
            return throw new Exception("No hay pokemons", 1);
        }

        foreach ($pokemons as $pokemon) {
            // Get stats for each pokemon
            $stats = $this->pokeApi->stats($pokemon['name']);
            $catchRate =  $this->pokeApi->catchRate($pokemon['name']);
            $builderPokemon =  new BuilderPokemon();

            $builderPokemon
                ->setName($pokemon['name'])
                ->setLevel(1)
                ->setHealthPoints($stats['hp'] ?? 0)
                ->setAttack($stats['attack'] ?? 0)
                ->setDefense($stats['defense'] ?? 0)
                ->setSpeed($stats['speed'] ?? 0)
                ->setCatchRate($catchRate);

            $item =  $builderPokemon->getPokemon();
            
            $this->entityManager->persist($item);
            $this->entityManager->flush();
        }
    }

    // This method should fetch all types from the API and persist them in the database.
    public function saveTypes()
    {
        $types = $this->pokeApi->types();
        
        if (empty($types) || !isset($types['results'])) {
            throw new \Exception("No hay tipos de pokemon", 1);
        }

        foreach ($types['results'] as $type) {
            $existingType = $this->entityManager->getRepository(\App\Entity\Type::class)
                ->findOneBy(['name' => $type['name']]);
            if ($existingType) {
                continue;
            }

            $moves = $this->pokeApi->getMovesFromType($type['name']);


            $typeEntity = new \App\Entity\Type();

            $typeEntity->setName($type['name']);
            $saveTypeEntity =  $this->entityManager->persist($typeEntity);

            $count =  0;
            foreach ($moves as $move) {
                
                if($count > 20){
                    continue;
                }

                $existingMove = $this->entityManager->getRepository(\App\Entity\Move::class)
                    ->findOneBy(['name' => $move['name']]);
                if ($existingMove) {
                    continue;
                }

                // The code below ensures that each Move is associated with its Type.
                $moveEntity = new \App\Entity\Move();
                $moveEntity->setName($move['name']);
                $moveEntity->setType($typeEntity);
                $this->entityManager->persist($moveEntity);
                $count++;
            }
        }

        $this->entityManager->flush();
    }
}