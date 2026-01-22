<?php
    
    namespace App\Game;
    
    use App\Entity\Carte;
    use App\Entity\CartePartie;
    use App\Entity\Joueur;
    use App\Entity\Partie;
    use Doctrine\ORM\EntityManagerInterface;
    use App\Repository\CartePartieRepository;
    use App\Repository\CarteRepository;
    
    class DeckService
    {
        public function __construct(
            private EntityManagerInterface $em,
            private CarteRepository        $carteRepo,
            private CartePartieRepository  $cartePartieRepo,
        )
        {
        }
        
        public function seedDeck(Partie $partie, int $copiesParCarte = 2): void
        {
            $cartes = $this->carteRepo->findAll();
            $ordre = 1;
            
            for ($k = 0; $k < $copiesParCarte; $k++) {
                foreach ($cartes as $carte) {
                    $cp = new CartePartie();
                    $cp->setPartie($partie);
                    $cp->setCarte($carte);
                    $cp->setEmplacement('PIOCHE');
                    $cp->setOrdrePioche($ordre++);
                    
                    $this->em->persist($cp);
                }
            }
        }
        
        
        public function shuffle(Partie $partie): void
        {
            $cartesPioche = $this->cartePartieRepo->findBy([
                'partie' => $partie,
                'emplacement' => 'PIOCHE',
            ]);
            
            // mélange PHP (simple)
            shuffle($cartesPioche);
            
            $i = 1;
            foreach ($cartesPioche as $cp) {
                $cp->setOrdrePioche($i++);
            }
        }
        
        public function draw(Joueur $joueur, int $n): void
        {
            $partie = $joueur->getPartie();
            
            $cartes = $this->cartePartieRepo->findNextInDeck($partie, $n);
            
            foreach ($cartes as $cp) {
                $cp->setEmplacement('MAIN');
                $cp->setJoueur($joueur);
            }
        }
        
    }
