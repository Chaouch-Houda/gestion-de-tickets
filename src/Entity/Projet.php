<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_projet = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $duree = null;

    #[ORM\Column(length: 255)]
    private ?string $pre_requis = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\OneToOne(inversedBy: 'projet', cascade: ['persist', 'remove'])]
    private ?User $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'enseignantProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $enseignant = null;

    #[ORM\Column]
    private ?bool $isSelected = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProjet(): ?int
    {
        return $this->id_projet;
    }

    public function setIdProjet(int $id_projet): static
    {
        $this->id_projet = $id_projet;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPreRequis(): ?string
    {
        return $this->pre_requis;
    }

    public function setPreRequis(string $pre_requis): static
    {
        $this->pre_requis = $pre_requis;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getEtudiant(): ?User
    {
        return $this->etudiant;
    }

    public function setEtudiant(?User $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getEnseignant(): ?User
    {
        return $this->enseignant;
    }

    public function setEnseignant(?User $enseignant): static
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function isSelected(): ?bool
    {
        return $this->isSelected;
    }

    public function setSelected(bool $isSelected): static
    {
        $this->isSelected = $isSelected;

        return $this;
    }
}
