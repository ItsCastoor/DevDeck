<?php
    
    namespace App\Controller;
    
    use App\Entity\Joueur;
    use App\Entity\Partie;
    use App\Game\PlayCardService;
    use App\Repository\CartePartieRepository;
    use App\Repository\JoueurRepository;
    use App\Repository\PartieRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\HttpFoundation\Request;
    
    #[Route('/partie')]
    final class GameController extends AbstractController
    {
        #[Route('/{id}', name: 'voir_partie', methods: ['GET'])]
        public function show(
            Partie                $partie,
            JoueurRepository      $joueurRepo,
            CartePartieRepository $cartePartieRepo
        ): Response
        {
            $joueurHumain = $joueurRepo->findOneBy([
                'partie' => $partie,
                'type' => Joueur::TYPE_HUMAIN,
            ]);
            
            $joueurIA = $joueurRepo->findOneBy([
                'partie' => $partie,
                'type' => Joueur::TYPE_IA,
            ]);
            
            $mainHumain = $joueurHumain ? $cartePartieRepo->findBy([
                'partie' => $partie,
                'joueur' => $joueurHumain,
                'emplacement' => 'MAIN',
            ]) : [];
            
            $mainIA = $joueurIA ? $cartePartieRepo->findBy([
                'partie' => $partie,
                'joueur' => $joueurIA,
                'emplacement' => 'MAIN',
            ]) : [];
            
            $plateauHumain = $joueurHumain ? $cartePartieRepo->findBy([
                'partie' => $partie,
                'joueur' => $joueurHumain,
                'emplacement' => 'PLATEAU',
            ]) : [];
            
            $plateauIA = $joueurIA ? $cartePartieRepo->findBy([
                'partie' => $partie,
                'joueur' => $joueurIA,
                'emplacement' => 'PLATEAU',
            ]) : [];
            
            return $this->render('game/show.html.twig', [
                'partie' => $partie,
                'joueurHumain' => $joueurHumain,
                'joueurIA' => $joueurIA,
                'mainHumain' => $mainHumain,
                'mainIA' => $mainIA,
                'plateauHumain' => $plateauHumain,
                'plateauIA' => $plateauIA,
            ]);
        }
        
        #[Route('/{id}/play/{cartePartieId}', name: 'partie_play_card', methods: ['POST'])]
        public function playCard(
            int                    $id,
            int                    $cartePartieId,
            Request                $request,
            PlayCardService        $playCardService,
            EntityManagerInterface $em,
            PartieRepository       $partieRepo,
            JoueurRepository       $joueurRepo,
        ): Response
        {
            $partie = $partieRepo->find($id);
            if (!$partie) {
                throw $this->createNotFoundException();
            }
            
            // À adapter selon ton auth : comment tu retrouves le joueur courant
            // Exemple si tu stockes l'ID joueur en session :
            $joueurId = $request->getSession()->get('joueur_id');
            $joueur = $joueurId ? $joueurRepo->find($joueurId) : null;
            
            if (!$joueur || $joueur->getPartie()?->getId() !== $partie->getId()) {
                throw $this->createAccessDeniedException();
            }
            
            // CSRF
            if (!$this->isCsrfTokenValid('play_card_' . $cartePartieId, (string)$request->request->get('_token'))) {
                throw $this->createAccessDeniedException('CSRF invalide');
            }
            
            $playCardService->playFromHandToBoard($partie, $joueur, $cartePartieId);
            
            $em->flush();
            
            return $this->redirectToRoute('partie_debug', ['id' => $partie->getId()]);
        }
    }
