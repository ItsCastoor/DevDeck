<?php
    
    namespace App\DataFixtures;
    
    use App\Entity\Carte;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Persistence\ObjectManager;
    
    class CarteFixtures extends Fixture
    {
        public function load(ObjectManager $manager): void
        {
            $cartes = [
                [
                    'nom' => 'Client Pressé',
                    'type' => 'PERSONNE',
                    'description' => 'Veut tout, tout de suite.',
                    'coutPd' => 2,
                    'gainArgent' => 0,
                    'effet' => 'Augmente la pression sur le projet.',
                ],
                [
                    'nom' => 'Bug en Production',
                    'type' => 'EVENEMENT',
                    'description' => 'Ça marchait en local.',
                    'coutPd' => 0,
                    'gainArgent' => 0,
                    'effet' => 'Bloque le projet pendant 1 tour.',
                ],
                [
                    'nom' => 'Développeur Senior',
                    'type' => 'PERSONNE',
                    'description' => 'Il a tout vu, tout cassé.',
                    'coutPd' => 3,
                    'gainArgent' => 2,
                    'effet' => 'Réduit le coût des cartes.',
                ],
                [
                    'nom' => 'StackOverflow',
                    'type' => 'OUTIL',
                    'description' => 'Copier-coller assumé.',
                    'coutPd' => 1,
                    'gainArgent' => 0,
                    'effet' => 'Annule un bug.',
                ],
                [
                    'nom' => 'Deadline Imposée',
                    'type' => 'EVENEMENT',
                    'description' => 'C’était pour hier.',
                    'coutPd' => 0,
                    'gainArgent' => 0,
                    'effet' => 'Passe immédiatement au tour suivant.',
                ],
            ];
            
            foreach ($cartes as $data) {
                $carte = new Carte();
                $carte->setNom($data['nom']);
                $carte->setType($data['type']);
                $carte->setDescription($data['description']);
                $carte->setCoutPd($data['coutPd']);
                $carte->setGainArgent($data['gainArgent']);
                $carte->setEffet($data['effet']);
                
                $manager->persist($carte);
            }
            
            $manager->flush();
        }
    }
