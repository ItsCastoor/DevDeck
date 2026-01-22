<?php
    
    namespace App\Entity;
    
    use App\Repository\UtilisateurRepository;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;
    
    #[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
    class Utilisateur
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;
        
        #[ORM\Column(length: 100, unique: true)]
        private ?string $email = null;
        
        #[ORM\Column(length: 255)]
        private ?string $motDePasse = null;
        
        #[ORM\Column(length: 50, unique: true)]
        private ?string $pseudo = null;
        
        #[ORM\Column]
        private ?\DateTimeImmutable $dateCreation = null;
        
        #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
        private ?Partie $partieActive = null;
        
        /**
         * @var Collection<int, Joueur>
         */
        #[ORM\OneToMany(targetEntity: Joueur::class, mappedBy: 'utilisateur')]
        private Collection $joueurs;
        
        public function __construct()
        {
            $this->dateCreation = new \DateTimeImmutable();
            $this->joueurs = new ArrayCollection();
        }
        
        public function getId(): ?int
        {
            return $this->id;
        }
        
        public function getEmail(): ?string
        {
            return $this->email;
        }
        
        public function setEmail(string $email): static
        {
            $this->email = $email;
            
            return $this;
        }
        
        public function getMotDePasse(): ?string
        {
            return $this->motDePasse;
        }
        
        public function setMotDePasse(string $motDePasse): static
        {
            $this->motDePasse = $motDePasse;
            
            return $this;
        }
        
        public function getPseudo(): ?string
        {
            return $this->pseudo;
        }
        
        public function setPseudo(string $pseudo): static
        {
            $this->pseudo = $pseudo;
            
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
        
        public function getPartieActive(): ?Partie
        {
            return $this->partieActive;
        }
        
        public function setPartieActive(?Partie $partieActive): static
        {
            $this->partieActive = $partieActive;
            
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
                $joueur->setUtilisateur($this);
            }
            
            return $this;
        }
        
        public function removeJoueur(Joueur $joueur): static
        {
            if ($this->joueurs->removeElement($joueur)) {
                // set the owning side to null (unless already changed)
                if ($joueur->getUtilisateur() === $this) {
                    $joueur->setUtilisateur(null);
                }
            }
            
            return $this;
        }
    }
