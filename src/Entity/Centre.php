<?php

namespace App\Entity;

use App\Repository\CentreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CentreRepository::class)]
class Centre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomCentre = null;

    #[ORM\Column(length: 255)]
    private ?string $District = null;

    #[ORM\ManyToOne(inversedBy: 'centre_examen')]
    private ?Etudient $etudient = null;

    #[ORM\ManyToOne(inversedBy: 'centre_examen')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salle $salle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCentre(): ?string
    {
        return $this->NomCentre;
    }

    public function setNomCentre(string $NomCentre): static
    {
        $this->NomCentre = $NomCentre;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->District;
    }

    public function setDistrict(string $District): static
    {
        $this->District = $District;

        return $this;
    }

    public function getEtudient(): ?Etudient
    {
        return $this->etudient;
    }

    public function setEtudient(?Etudient $etudient): static
    {
        $this->etudient = $etudient;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
    }
}
