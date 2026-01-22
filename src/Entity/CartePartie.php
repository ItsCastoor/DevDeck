<?php
    
    namespace App\Entity;
    
    use App\Repository\CartePartieRepository;
    use Doctrine\ORM\Mapping as ORM;
    
    #[ORM\Entity(repositoryClass: CartePartieRepository::class)]
    class CartePartie
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;
        
        #[ORM\Column(length: 20)]
        private ?string $emplacement = null;
        
        #[ORM\Column(type: 'integer', nullable: true)]
        private ?int $ordrePioche = null;
        
        #[ORM\ManyToOne(inversedBy: 'carteParties')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Partie $partie = null;
        
        #[ORM\ManyToOne(inversedBy: 'carteParties')]
        private ?Joueur $joueur = null;
        
        #[ORM\ManyToOne(inversedBy: 'carteParties')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Carte $carte = null;
        
        public function getId(): ?int
        {
            return $this->id;
        }
        
        public function getEmplacement(): ?string
        {
            return $this->emplacement;
        }
        
        public function setEmplacement(string $emplacement): static
        {
            $this->emplacement = $emplacement;
            
            return $this;
        }
        
        public function getOrdrePioche(): ?int
        {
            return $this->ordrePioche;
        }
        
        public function setOrdrePioche(?int $ordrePioche): static
        {
            $this->ordrePioche = $ordrePioche;
            
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
        
        public function getJoueur(): ?Joueur
        {
            return $this->joueur;
        }
        
        public function setJoueur(?Joueur $joueur): static
        {
            $this->joueur = $joueur;
            
            return $this;
        }
        
        public function getCarte(): ?Carte
        {
            return $this->carte;
        }
        
        public function setCarte(?Carte $carte): static
        {
            $this->carte = $carte;
            
            return $this;
        }
    }
