<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: UserRepository::class)]

class User implements UserInterface,  \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = []; 

    #[ORM\OneToMany(mappedBy: 'trainer', targetEntity: Pokemon::class)]
    private Collection $pokemonCollection; 

    public function __construct()
    {
        $this->pokemonCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername($username){
        $this->username =  $username;
        
        return $this;
    }

    public function setPassword($password){
        $this->password = $password;

        return $this;
    }
    
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function  setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPokemonCollection(): Collection
    {
        return $this->pokemonCollection;
    }

    public function addPokemon(Pokemon $pokemon): static
    {
        if (!$this->pokemonCollection->contains($pokemon)) {
            $this->pokemonCollection->add($pokemon);
            $pokemon->setTrainer($this);
        }

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function eraseCredentials(): void
    {
        // $this->plainPassword = null;
    }
}
