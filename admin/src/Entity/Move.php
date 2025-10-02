<?php

namespace App\Entity;

use App\Repository\MoveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoveRepository::class)]
class Move
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: \App\Entity\Type::class)]
    #[ORM\JoinColumn(name: "type_id", referencedColumnName: "id", nullable: true)]
    private ?\App\Entity\Type $type = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?\App\Entity\Type
    {
        return $this->type;
    }

    public function setType(?\App\Entity\Type $type): self
    {
        $this->type = $type;
        return $this;
    }
}
