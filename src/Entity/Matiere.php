<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Coefficient = null;

    #[ORM\OneToOne(inversedBy: 'matiere', cascade: ['persist', 'remove'])]
    private ?Note $note_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->Coefficient;
    }

    public function setCoefficient(int $Coefficient): static
    {
        $this->Coefficient = $Coefficient;

        return $this;
    }

    public function getNoteId(): ?Note
    {
        return $this->note_id;
    }

    public function setNoteId(?Note $note_id): static
    {
        $this->note_id = $note_id;

        return $this;
    }
}
