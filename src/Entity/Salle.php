<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Numero = null;

    #[ORM\OneToMany(mappedBy: 'salle', targetEntity: Centre::class)]
    private Collection $centre_examen;

    public function __construct()
    {
        $this->centre_examen = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->Numero;
    }

    public function setNumero(string $Numero): static
    {
        $this->Numero = $Numero;

        return $this;
    }

    /**
     * @return Collection<int, Centre>
     */
    public function getCentreExamen(): Collection
    {
        return $this->centre_examen;
    }

    public function addCentreExaman(Centre $centreExaman): static
    {
        if (!$this->centre_examen->contains($centreExaman)) {
            $this->centre_examen->add($centreExaman);
            $centreExaman->setSalle($this);
        }

        return $this;
    }

    public function removeCentreExaman(Centre $centreExaman): static
    {
        if ($this->centre_examen->removeElement($centreExaman)) {
            // set the owning side to null (unless already changed)
            if ($centreExaman->getSalle() === $this) {
                $centreExaman->setSalle(null);
            }
        }

        return $this;
    }
}
