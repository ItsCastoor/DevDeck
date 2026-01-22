<?php
    
    namespace App\Game;
    
    use App\Entity\Partie;
    use App\Entity\Joueur;
    use Doctrine\ORM\EntityManagerInterface;
    
    class GameFactory
    {
        public function __construct(
            private EntityManagerInterface $em,
            private DeckService            $deckService
        )
        {
        }
        
        public function createVsIA(): Partie
        {
            // 1️⃣ Création de la partie
            $partie = new Partie();
            $this->em->persist($partie);
            
            // Humain invité
            $joueurHumain = new Joueur();
            $joueurHumain->setPartie($partie);
            $joueurHumain->setArgent(0);
            $joueurHumain->setOrdreJeu(1);
            $joueurHumain->setType(Joueur::TYPE_HUMAIN); // nouveau champ
            $this->em->persist($joueurHumain);
            
            // IA
            $joueurIA = new Joueur();
            $joueurIA->setPartie($partie);
            $joueurIA->setArgent(0);
            $joueurIA->setOrdreJeu(2);
            $joueurIA->setType(Joueur::TYPE_IA);
            $this->em->persist($joueurIA);
            
            $this->em->flush(); // important pour avoir l'ID partie
            
            $this->deckService->seedDeck($partie, 2); // 10 cartes si tu as 5 modèles
            $this->deckService->shuffle($partie);
            $this->em->flush();
            
            $this->deckService->draw($joueurHumain, 5);
            $this->em->flush();
            $this->deckService->draw($joueurIA, 5);
            $this->em->flush();
            
            return $partie;
        }
        
    }
