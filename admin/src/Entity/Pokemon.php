<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\ManyToOne(targetEntity: \App\Entity\User::class)]
    #[ORM\JoinColumn(name: "trainer_id", referencedColumnName: "id", nullable: true)]
    private ?\App\Entity\User $trainer = null;

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

    public function setTrainer(?\App\Entity\User $trainer): self
    {
        $this->trainer = $trainer;
        return $this;
    }
}
