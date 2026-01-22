<?php
    
    namespace App\Repository;
    
    use App\Entity\CartePartie;
    use App\Entity\Joueur;
    use App\Entity\Partie;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;
    
    /**
     * @extends ServiceEntityRepository<CartePartie>
     */
    class CartePartieRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, CartePartie::class);
        }
        
        public function findNextInDeck(Partie $partie, int $limit): array
        {
            $query = $this->createQueryBuilder('cp')
                ->andWhere('cp.partie = :partie')
                ->andWhere('cp.emplacement = :emp')
                ->andWhere('cp.joueur IS NULL')
                ->setParameter('partie', $partie)
                ->setParameter('emp', 'PIOCHE')
                ->orderBy('cp.ordrePioche', 'ASC')
                ->setMaxResults($limit)
                ->getQuery();
            
            dump($query->getSQL(), $query->getParameters());
            
            dump([
                'count_partie' => $this->count(['partie' => $partie]),
                'count_pioche' => $this->count(['partie' => $partie, 'emplacement' => 'PIOCHE']),
            ]);
            
            return $query->getResult();
        }
        
        public function findPlayableCard(int $cartePartieId, Partie $partie, Joueur $joueur): ?CartePartie
        {
            return $this->createQueryBuilder('cp')
                ->andWhere('cp.id = :id')
                ->andWhere('cp.partie = :partie')
                ->andWhere('cp.joueur = :joueur')
                ->andWhere('cp.emplacement = :emp')
                ->setParameter('id', $cartePartieId)
                ->setParameter('partie', $partie)
                ->setParameter('joueur', $joueur)
                ->setParameter('emp', 'MAIN')
                ->getQuery()
                ->getOneOrNullResult();
        }
        
    }
