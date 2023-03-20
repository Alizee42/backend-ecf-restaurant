<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jour = null;

    #[ORM\Column(length: 255)]
    private ?string $ouvertureMatin = null;

    #[ORM\Column(length: 255)]
    private ?string $fermetureMatin = null;

    #[ORM\Column(length: 255)]
    private ?string $ouvertureSoir = null;

    #[ORM\Column(length: 255)]
    private ?string $fermetureSoir = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getOuvertureMatin(): ?string
    {
        return $this->ouvertureMatin;
    }

    public function setOuvertureMatin(string $ouvertureMatin): self
    {
        $this->ouvertureMatin = $ouvertureMatin;

        return $this;
    }

    public function getFermetureMatin(): ?string
    {
        return $this->fermetureMatin;
    }

    public function setFermetureMatin(string $fermetureMatin): self
    {
        $this->fermetureMatin = $fermetureMatin;

        return $this;
    }

    public function getOuvertureSoir(): ?string
    {
        return $this->ouvertureSoir;
    }

    public function setOuvertureSoir(string $ouvertureSoir): self
    {
        $this->ouvertureSoir = $ouvertureSoir;

        return $this;
    }

    public function getFermetureSoir(): ?string
    {
        return $this->fermetureSoir;
    }

    public function setFermetureSoir(string $fermetureSoir): self
    {
        $this->fermetureSoir = $fermetureSoir;

        return $this;
    }
}
