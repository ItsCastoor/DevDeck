<?php
    
    namespace App\Entity;
    
    use App\Repository\PartieRepository;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    
    #[ORM\Entity(repositoryClass: PartieRepository::class)]
    class Partie
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;
        
        #[ORM\Column(length: 100)]
        private ?string $statut = null;
        
        #[ORM\Column]
        private ?int $numeroTour = null;
        
        #[ORM\Column]
        private ?\DateTimeImmutable $dateCreation = null;
        
        /**
         * @var Collection<int, Utilisateur>
         */
        #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'partieActive')]
        private Collection $utilisateurs;
        
        /**
         * @var Collection<int, Joueur>
         */
        #[ORM\OneToMany(targetEntity: Joueur::class, mappedBy: 'partie')]
        private Collection $joueurs;
        
        /**
         * @var Collection<int, CartePartie>
         */
        #[ORM\OneToMany(targetEntity: CartePartie::class, mappedBy: 'partie')]
        private Collection $carteParties;
        
        public function __construct()
        {
            $this->statut = 'EN_ATTENTE';
            $this->numeroTour = 1;
            $this->dateCreation = new \DateTimeImmutable();
            $this->utilisateurs = new ArrayCollection();
            $this->joueurs = new ArrayCollection();
            $this->carteParties = new ArrayCollection();
        }
        
        public function getId(): ?int
        {
            return $this->id;
        }
        
        public function getStatut(): ?string
        {
            return $this->statut;
        }
        
        public function setStatut(string $statut): static
        {
            $this->statut = $statut;
            
            return $this;
        }
        
        public function getNumeroTour(): ?int
        {
            return $this->numeroTour;
        }
        
        public function setNumeroTour(int $numeroTour): static
        {
            $this->numeroTour = $numeroTour;
            
            return $this;
        }
        
        public function getDateCreation(): ?\DateTimeImmutable
        {
            return $this->dateCreation;
        }
        
        public function setDateCreation(\DateTimeImmutable $dateCreation): static
        {
            $this->dateCreation = $dateCreation;
            
            return $this;
        }
        
        /**
         * @return Collection<int, Utilisateur>
         */
        public function getUtilisateurs(): Collection
        {
            return $this->utilisateurs;
        }
        
        public function addUtilisateur(Utilisateur $utilisateur): static
        {
            if (!$this->utilisateurs->contains($utilisateur)) {
                $this->utilisateurs->add($utilisateur);
                $utilisateur->setPartieActive($this);
            }
            
            return $this;
        }
        
        public function removeUtilisateur(Utilisateur $utilisateur): static
        {
            if ($this->utilisateurs->removeElement($utilisateur)) {
                // set the owning side to null (unless already changed)
                if ($utilisateur->getPartieActive() === $this) {
                    $utilisateur->setPartieActive(null);
                }
            }
            
            return $this;
        }
        
        /**
         * @return Collection<int, Joueur>
         */
        public function getJoueurs(): Collection
        {
            return $this->joueurs;
        }
        
        public function addJoueur(Joueur $joueur): static
        {
            if (!$this->joueurs->contains($joueur)) {
                $this->joueurs->add($joueur);
                $joueur->setPartie($this);
            }
            
            return $this;
        }
        
        public function removeJoueur(Joueur $joueur): static
        {
            if ($this->joueurs->removeElement($joueur)) {
                // set the owning side to null (unless already changed)
                if ($joueur->getPartie() === $this) {
                    $joueur->setPartie(null);
                }
            }
            
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
                $carteParty->setPartie($this);
            }
            
            return $this;
        }
        
        public function removeCarteParty(CartePartie $carteParty): static
        {
            if ($this->carteParties->removeElement($carteParty)) {
                // set the owning side to null (unless already changed)
                if ($carteParty->getPartie() === $this) {
                    $carteParty->setPartie(null);
                }
            }
            
            return $this;
        }
    }
