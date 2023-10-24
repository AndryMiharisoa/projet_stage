<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valeur = null;

    #[ORM\OneToMany(mappedBy: 'note', targetEntity: Etudient::class)]
    private Collection $etudient_id;

    #[ORM\OneToOne(mappedBy: 'note_id', cascade: ['persist', 'remove'])]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'node_id')]
    private ?Etudient $etudient = null;

    public function __construct()
    {
        $this->etudient_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * @return Collection<int, Etudient>
     */
    public function getEtudientId(): Collection
    {
        return $this->etudient_id;
    }

    public function addEtudientId(Etudient $etudientId): static
    {
        if (!$this->etudient_id->contains($etudientId)) {
            $this->etudient_id->add($etudientId);
            $etudientId->setNote($this);
        }

        return $this;
    }

    public function removeEtudientId(Etudient $etudientId): static
    {
        if ($this->etudient_id->removeElement($etudientId)) {
            // set the owning side to null (unless already changed)
            if ($etudientId->getNote() === $this) {
                $etudientId->setNote(null);
            }
        }

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        // unset the owning side of the relation if necessary
        if ($matiere === null && $this->matiere !== null) {
            $this->matiere->setNoteId(null);
        }

        // set the owning side of the relation if necessary
        if ($matiere !== null && $matiere->getNoteId() !== $this) {
            $matiere->setNoteId($this);
        }

        $this->matiere = $matiere;

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
}
