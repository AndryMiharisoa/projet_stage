<?php

namespace App\Entity;

use App\Repository\EtudientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudientRepository::class)]
class Etudient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $Etablissement = null;

    #[ORM\Column(length: 255)]
    private ?string $Region = null;

    #[ORM\Column(length: 255)]
    private ?string $District = null;

    #[ORM\Column(length: 255)]
    private ?string $Serie = null;

    #[ORM\Column(options: ["default" => 0], nullable: true)]
    private ?bool $EstVerifie = null;


    #[ORM\Column(nullable: true)]
    private ?int $Salle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Facultative = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Collective = null;

    #[ORM\OneToMany(mappedBy: 'etudient', targetEntity: Centre::class)]
    private Collection $centre_examen;

    #[ORM\OneToMany(mappedBy: 'etudient', targetEntity: Note::class)]
    private Collection $node_id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $convocation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $individuel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Candidat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Pere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Mere = null;

    #[ORM\Column(length: 255)]
    private ?string $session = null;

    #[ORM\Column(length: 255)]
    private ?string $Genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Telephone = null;

    public function __construct()
    {
        $this->centre_examen = new ArrayCollection();
        $this->node_id = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $DateNaissance): static
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->Etablissement;
    }

    public function setEtablissement(string $Etablissement): static
    {
        $this->Etablissement = $Etablissement;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->Region;
    }

    public function setRegion(string $Region): static
    {
        $this->Region = $Region;

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

    public function getSerie(): ?string
    {
        return $this->Serie;
    }

    public function setSerie(string $Serie): static
    {
        $this->Serie = $Serie;

        return $this;
    }

    public function isEstVerifie(): ?bool
    {
        return $this->EstVerifie;
    }

    public function setEstVerifie(bool $EstVerifie): static
    {
        $this->EstVerifie = $EstVerifie;

        return $this;
    }

    public function getSalle(): ?int
    {
        return $this->Salle;
    }

    public function setSalle(int $Salle): static
    {
        $this->Salle = $Salle;

        return $this;
    }

    public function getFacultative(): ?string
    {
        return $this->Facultative;
    }

    public function setFacultative(string $Facultative): static
    {
        $this->Facultative = $Facultative;

        return $this;
    }

    public function getCollective(): ?string
    {
        return $this->Collective;
    }

    public function setCollective(string $Collective): static
    {
        $this->Collective = $Collective;

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
            $centreExaman->setEtudient($this);
        }

        return $this;
    }

    public function removeCentreExaman(Centre $centreExaman): static
    {
        if ($this->centre_examen->removeElement($centreExaman)) {
            // set the owning side to null (unless already changed)
            if ($centreExaman->getEtudient() === $this) {
                $centreExaman->setEtudient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNodeId(): Collection
    {
        return $this->node_id;
    }

    public function addNodeId(Note $nodeId): static
    {
        if (!$this->node_id->contains($nodeId)) {
            $this->node_id->add($nodeId);
            $nodeId->setEtudient($this);
        }

        return $this;
    }

    public function removeNodeId(Note $nodeId): static
    {
        if ($this->node_id->removeElement($nodeId)) {
            // set the owning side to null (unless already changed)
            if ($nodeId->getEtudient() === $this) {
                $nodeId->setEtudient(null);
            }
        }

        return $this;
    }

    public function getConvocation(): ?string
    {
        return $this->convocation;
    }

    public function setConvocation(?string $convocation): static
    {
        $this->convocation = $convocation;

        return $this;
    }

    public function getIndividuel(): ?string
    {
        return $this->individuel;
    }

    public function setIndividuel(?string $individuel): static
    {
        $this->individuel = $individuel;

        return $this;
    }

    public function getCandidat(): ?string
    {
        return $this->Candidat;
    }

    public function setCandidat(string $Candidat): static
    {
        $this->Candidat = $Candidat;

        return $this;
    }

    public function getPere(): ?string
    {
        return $this->Pere;
    }

    public function setPere(?string $Pere): static
    {
        $this->Pere = $Pere;

        return $this;
    }

    public function getMere(): ?string
    {
        return $this->Mere;
    }

    public function setMere(?string $Mere): static
    {
        $this->Mere = $Mere;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): static
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(?string $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }
}
