<?php
    
    namespace App\Entity;
    
    use App\Repository\CarteRepository;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    
    #[ORM\Entity(repositoryClass: CarteRepository::class)]
    class Carte
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;
        
        #[ORM\Column(length: 100, unique: true)]
        private ?string $nom = null;
        
        #[ORM\Column(length: 100)]
        private ?string $type = null;
        
        #[ORM\Column(length: 150)]
        private ?string $description = null;
        
        #[ORM\Column(type: Types::SMALLINT, nullable: true)]
        private ?int $coutPD = null;
        
        #[ORM\Column(type: Types::SMALLINT, nullable: true)]
        private ?int $gainArgent = null;
        
        #[ORM\Column(length: 200)]
        private ?string $effet = null;
        
        /**
         * @var Collection<int, CartePartie>
         */
        #[ORM\OneToMany(targetEntity: CartePartie::class, mappedBy: 'carte')]
        private Collection $carteParties;
        
        public function __construct()
        {
            $this->carteParties = new ArrayCollection();
        }
        
        public function getId(): ?int
        {
            return $this->id;
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
        
        public function getType(): ?string
        {
            return $this->type;
        }
        
        public function setType(string $type): static
        {
            $this->type = $type;
            
            return $this;
        }
        
        public function getDescription(): ?string
        {
            return $this->description;
        }
        
        public function setDescription(string $description): static
        {
            $this->description = $description;
            
            return $this;
        }
        
        public function getCoutPD(): ?int
        {
            return $this->coutPD;
        }
        
        public function setCoutPD(?int $coutPD): static
        {
            $this->coutPD = $coutPD;
            
            return $this;
        }
        
        public function getGainArgent(): ?int
        {
            return $this->gainArgent;
        }
        
        public function setGainArgent(?int $gainArgent): static
        {
            $this->gainArgent = $gainArgent;
            
            return $this;
        }
        
        public function getEffet(): ?string
        {
            return $this->effet;
        }
        
        public function setEffet(string $effet): static
        {
            $this->effet = $effet;
            
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
                $carteParty->setCarte($this);
            }
            
            return $this;
        }
        
        public function removeCarteParty(CartePartie $carteParty): static
        {
            if ($this->carteParties->removeElement($carteParty)) {
                // set the owning side to null (unless already changed)
                if ($carteParty->getCarte() === $this) {
                    $carteParty->setCarte(null);
                }
            }
            
            return $this;
        }
    }
