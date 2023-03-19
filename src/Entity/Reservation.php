<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column(length: 255)]
    private ?string $date = null;

    #[ORM\Column(length: 255)]
    private ?string $heurePrevu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombreConvive = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $allergie = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeurePrevu(): ?string
    {
        return $this->heurePrevu;
    }

    public function setHeurePrevu(string $heurePrevu): self
    {
        $this->heurePrevu = $heurePrevu;

        return $this;
    }

    public function getNombreConvive(): ?string
    {
        return $this->nombreConvive;
    }

    public function setNombreConvive(?string $nombreConvive): self
    {
        $this->nombreConvive = $nombreConvive;

        return $this;
    }

    public function getAllergie(): ?string
    {
        return $this->allergie;
    }

    public function setAllergie(?string $allergie): self
    {
        $this->allergie = $allergie;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
