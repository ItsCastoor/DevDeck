<?php
    
    namespace App\Command;
    
    use App\Game\GameFactory;
    use Symfony\Component\Console\Attribute\AsCommand;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Style\SymfonyStyle;
    
    #[AsCommand(
        name: 'game:create-ia',
        description: 'Creer une partie DevDeck contre l\'IA',
    )]
    class GameCreateIaCommand extends Command
    {
        public function __construct(private GameFactory $gameFactory)
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
            // 👉 Appel du moteur de jeu
            $partie = $this->gameFactory->createVsIA();
            
            // 👉 Affichage simple
            $output->writeln('<info>Partie créée avec succès</info>');
            $output->writeln('ID de la partie : ' . $partie->getId());
            
            return Command::SUCCESS;
        }
    }
