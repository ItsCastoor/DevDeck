<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $argent = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $ordreJeu = null;

    /**
     * @var Collection<int, ProjetEnCours>
     */
    #[ORM\OneToMany(targetEntity: ProjetEnCours::class, mappedBy: 'joueur')]
    private Collection $projetEnCours;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Partie $partie = null;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    private ?Utilisateur $utilisateur = null;

    /**
     * @var Collection<int, CartePartie>
     */
    #[ORM\OneToMany(targetEntity: CartePartie::class, mappedBy: 'joueur')]
    private Collection $carteParties;

    public function __construct()
    {
        $this->projetEnCours = new ArrayCollection();
        $this->carteParties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArgent(): ?int
    {
        return $this->argent;
    }

    public function setArgent(int $argent): static
    {
        $this->argent = $argent;

        return $this;
    }

    public function getOrdreJeu(): ?int
    {
        return $this->ordreJeu;
    }

    public function setOrdreJeu(?int $ordreJeu): static
    {
        $this->ordreJeu = $ordreJeu;

        return $this;
    }

    /**
     * @return Collection<int, ProjetEnCours>
     */
    public function getProjetEnCours(): Collection
    {
        return $this->projetEnCours;
    }

    public function addProjetEnCour(ProjetEnCours $projetEnCour): static
    {
        if (!$this->projetEnCours->contains($projetEnCour)) {
            $this->projetEnCours->add($projetEnCour);
            $projetEnCour->setJoueur($this);
        }

        return $this;
    }

    public function removeProjetEnCour(ProjetEnCours $projetEnCour): static
    {
        if ($this->projetEnCours->removeElement($projetEnCour)) {
            // set the owning side to null (unless already changed)
            if ($projetEnCour->getJoueur() === $this) {
                $projetEnCour->setJoueur(null);
            }
        }

        return $this;
    }

    public function getPartie(): ?Partie
    {
        return $this->partie;
    }

    public function setPartie(?Partie $partie): static
    {
        $this->partie = $partie;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, CartePartie>
     */
    public function getCarteParties(): Collection
    {
        return $this->carteParties;
    }

    public function addCarteParty(CartePartie $carteParty): static
    {
        if (!$this->carteParties->contains($carteParty)) {
            $this->carteParties->add($carteParty);
            $carteParty->setJoueur($this);
        }

        return $this;
    }

    public function removeCarteParty(CartePartie $carteParty): static
    {
        if ($this->carteParties->removeElement($carteParty)) {
            // set the owning side to null (unless already changed)
            if ($carteParty->getJoueur() === $this) {
                $carteParty->setJoueur(null);
            }
        }

        return $this;
    }
}
