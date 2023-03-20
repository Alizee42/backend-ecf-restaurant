<?php

namespace App\Entity;

use App\Repository\PlaceDisponibleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceDisponibleRepository::class)]
class PlaceDisponible
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nombre = null;

    #[ORM\Column]
    private ?int $valeurParDefaut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getValeurParDefaut(): ?int
    {
        return $this->valeurParDefaut;
    }

    public function setValeurParDefaut(int $valeurParDefaut): self
    {
        $this->valeurParDefaut = $valeurParDefaut;

        return $this;
    }
}
