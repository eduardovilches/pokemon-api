<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nickname = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $health_points = null;

    #[ORM\Column]
    private ?int $attack = null;

    #[ORM\Column]
    private ?int $defense = null;

    #[ORM\Column]
    private ?int $speed = null;

    #[ORM\Column]
    private ?int $catch_rate = null;

    #[ORM\ManyToOne(inversedBy: 'pokemonCollection')] 
    #[ORM\JoinColumn(name: "trainer_id", referencedColumnName: "id", nullable: true)]
    private ?\App\Entity\User $trainer = null;
    
    /**
     * @var \Doctrine\Common\Collections\Collection<int, \App\Entity\Type>
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Type", inversedBy="pokemons")
     * @ORM\JoinTable(name="pokemon_type")
     */
    private $types;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, \App\Entity\Move>
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Move", inversedBy="pokemon")
     * @ORM\JoinTable(name="pokemon_move",
     *      joinColumns={@ORM\JoinColumn(name="pokemon_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="move_id", referencedColumnName="id")}
     * )
     */
    private $moves;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->moves =  new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function setHealthPoints(int $healthPoints): self
    {
        $this->health_points = $healthPoints;
        return $this;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;
        return $this;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;
        return $this;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;
        return $this;
    }

    public function setCatchRate(int $catchRate): self
    {
        $this->catch_rate = $catchRate;
        return $this;
    }

    public function getTrainer(): ?\App\Entity\User
    {
        return $this->trainer;
    }

    public function setTrainer(?\App\Entity\User $trainer): self
    {
        $this->trainer = $trainer;
        return $this;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function addType(\App\Entity\Type $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(\App\Entity\Type $type): static
    {
        $this->types->removeElement($type);
        return $this;
    }

       /**
     * @return \Doctrine\Common\Collections\Collection<int, \App\Entity\Move>
     */
    public function getMoves()
    {
        return $this->moves;
    }

    public function addMove(\App\Entity\Move $move): self
    {
        if (!$this->moves->contains($move)) {
            $this->moves[] = $move;
        }
        return $this;
    }

    public function removeMove(\App\Entity\Move $move): self
    {
        $this->moves->removeElement($move);
        return $this;
    }
}
