<?php
    
    namespace App\Entity;
    
    use App\Repository\ProjetEnCoursRepository;
    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    
    #[ORM\Entity(repositoryClass: ProjetEnCoursRepository::class)]
    class ProjetEnCours
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;
        
        #[ORM\Column(type: Types::SMALLINT, nullable: true)]
        private ?int $avancementPD = null;
        
        #[ORM\Column(nullable: true)]
        private ?bool $estBloque = null;
        
        #[ORM\Column(length: 100, nullable: true)]
        private ?string $modificateursJson = null;
        
        #[ORM\OneToOne(cascade: ['persist', 'remove'])]
        #[ORM\JoinColumn(nullable: false)]
        private ?CartePartie $cartePartie = null;
        
        #[ORM\ManyToOne(inversedBy: 'projetEnCours')]
        #[ORM\JoinColumn(nullable: false)]
        private ?joueur $joueur = null;
        
        public function getId(): ?int
        {
            return $this->id;
        }
        
        public function getAvancementPD(): ?int
        {
            return $this->avancementPD;
        }
        
        public function setAvancementPD(?int $avancementPD): static
        {
            $this->avancementPD = $avancementPD;
            
            return $this;
        }
        
        public function isEstBloque(): ?bool
        {
            return $this->estBloque;
        }
        
        public function setEstBloque(?bool $estBloque): static
        {
            $this->estBloque = $estBloque;
            
            return $this;
        }
        
        public function getModificateursJson(): ?string
        {
            return $this->modificateursJson;
        }
        
        public function setModificateursJson(?string $modificateursJson): static
        {
            $this->modificateursJson = $modificateursJson;
            
            return $this;
        }
        
        public function getCartePartie(): ?CartePartie
        {
            return $this->cartePartie;
        }
        
        public function setCartePartie(CartePartie $cartePartie): static
        {
            $this->cartePartie = $cartePartie;
            
            return $this;
        }
        
        public function getJoueur(): ?joueur
        {
            return $this->joueur;
        }
        
        public function setJoueur(?joueur $joueur): static
        {
            $this->joueur = $joueur;
            
            return $this;
        }
    }
