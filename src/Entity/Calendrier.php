<?php

namespace App\Entity;

use App\Repository\CalendrierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendrierRepository::class)]
class Calendrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $alternant_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlternantId(): ?User
    {
        return $this->alternant_id;
    }

    public function setAlternantId(?User $alternant_id): static
    {
        $this->alternant_id = $alternant_id;

        return $this;
    }
}
