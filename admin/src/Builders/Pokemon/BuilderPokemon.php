<?php
namespace App\Builders\Pokemon;

use App\Entity\Pokemon;

class BuilderPokemon
{
    private Pokemon $pokemon;

    public function __construct()
    {
        $this->pokemon = new Pokemon();
    }

    public function setName(string $name): self
    {
        $this->pokemon->setName($name);
        return $this;
    }

    public function setNickname(?string $nickname): self
    {
        $this->pokemon->setNickname($nickname);
        return $this;
    }

    public function setLevel(int $level): self
    {
        $this->pokemon->setLevel($level);
        return $this;
    }

    public function setHealthPoints(int $hp): self
    {
        $this->pokemon->setHealthPoints($hp);
        return $this;
    }

    public function setAttack(int $attack): self
    {
        $this->pokemon->setAttack($attack);
        return $this;
    }

    public function setDefense(int $defense): self
    {
        $this->pokemon->setDefense($defense);
        return $this;
    }

    public function setSpeed(int $speed): self
    {
        $this->pokemon->setSpeed($speed);
        return $this;
    }

    public function setCatchRate(int $catchRate): self
    {
        $this->pokemon->setCatchRate($catchRate);
        return $this;
    }

    public function setTrainer(?\App\Entity\User $trainer): self
    {
        $this->pokemon->setTrainer($trainer);
        return $this;
    }

    public function getPokemon(): Pokemon
    {
        return $this->pokemon;
    }
}
