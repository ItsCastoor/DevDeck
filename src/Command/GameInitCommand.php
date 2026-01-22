<?php
    
    namespace App\Command;
    
    use App\Entity\Partie;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Console\Attribute\AsCommand;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Style\SymfonyStyle;
    
    #[AsCommand(
        name: 'game:init',
        description: 'Creer une partie de test'
    )]
    class GameInitCommand extends Command
    {
        public function __construct(private readonly EntityManagerInterface $entityManager)
        {
            parent::__construct();
        }
        
        protected function configure(): void
        {
            $this
                ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
                ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
        }
        
        protected function execute(InputInterface $input, OutputInterface $output): int
        {
            // 👉 ICI on utilise le constructeur
            $partie = new Partie();
            
            // Doctrine persiste
            $this->entityManager->persist($partie);
            $this->entityManager->flush();
            
            $output->writeln('Partie créée avec ID : ' . $partie->getId());
            
            return Command::SUCCESS;
        }
    }
