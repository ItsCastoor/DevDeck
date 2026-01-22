<?php
    
    namespace App\Game;
    
    use App\Entity\Joueur;
    use App\Entity\Partie;
    use App\Repository\CartePartieRepository;
    use Doctrine\ORM\EntityManagerInterface;
    
    class PlayCardService
    {
        public function __construct(
            private CartePartieRepository  $cartePartieRepo,
            private EntityManagerInterface $em,
        )
        {
        }
        
        public function playFromHandToBoard(Partie $partie, Joueur $joueur, int $cartePartieId): void
        {
            // 1) Récupérer carte jouable (MAIN + bonne partie + bon joueur)
            $cp = $this->cartePartieRepo->findPlayableCard($cartePartieId, $partie, $joueur);
            
            if (!$cp) {
                throw new \RuntimeException("Carte non jouable (pas en main / pas au joueur / mauvaise partie).");
            }
            
            // 2) TODO: vérifier tour du joueur actif
            // if ($partie->getJoueurActif()?->getId() !== $joueur->getId()) { ... }
            
            // 3) TODO: vérifier coût coutPD / ressources
            // $carte = $cp->getCarte();
            // if ($joueur->getPd() < $carte->getCoutPD()) { ... }
            // $joueur->setPd($joueur->getPd() - $carte->getCoutPD());
            
            // 4) Déplacer vers le plateau
            $cp->setEmplacement('PLATEAU');
            
            // 5) TODO: appliquer gainArgent / effet (plus tard via un EffectResolver)
            // $joueur->setArgent($joueur->getArgent() + $cp->getCarte()->getGainArgent());
            
            // flush fait dans le contrôleur (ou ici, au choix)
        }
    }
