<?php

namespace App\Game;

use App\Entity\Partie;
use App\Entity\Joueur;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;

class GameFactory
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function createVsIA(?Utilisateur $utilisateur = null): Partie
    {
        $partie = new Partie();

        // Joueur humain
        if ($utilisateur) {
            $joueurHumain = new Joueur();
            $joueurHumain->setUtilisateur($utilisateur);
            $joueurHumain->setPartie($partie);
            $joueurHumain->setArgent(0);
            $joueurHumain->setOrdreJeu(1);

            $this->em->persist($joueurHumain);
        }

        // Joueur IA
        $joueurIA = new Joueur();
        $joueurIA->setPartie($partie);
        $joueurIA->setArgent(0);
        $joueurIA->setOrdreJeu(2);

        $this->em->persist($partie);
        $this->em->persist($joueurIA);

        $this->em->flush();

        return $partie;
    }
}
