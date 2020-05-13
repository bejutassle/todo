<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TaskList;
use App\Factory\Provider1Factory;
use App\Factory\Provider2Factory;

class CreateTaskListCommand extends Command
{
    protected static $defaultName = 'app:create-task-list';
    private $em;
    private $provider1;
    private $provider2;

    public function __construct(Provider1Factory $provider1, Provider2Factory $provider2, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->provider1 = $provider1;
        $this->provider2 = $provider2;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        /*
        Run migration
         */
        $command = $this->getApplication()->find('doctrine:migrations:migrate');
        $arguments = [];
        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);
        /*
        End run migration
         */

        $tasks = $this->em->getRepository(TaskList::class)->findAll();
        foreach ($tasks as $key => $entity){

            $this->em->remove($entity); 
        }

        $this->em->flush();

        $this->provider1->saveList();
        $this->provider2->saveList();

        $io->success('Task liste verileri oluşturuldu.');

        return 0;
    }
}
