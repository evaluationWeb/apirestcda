<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use App\Service\UserService;

#[AsCommand(
    name: 'app:user',
    description: 'Création de compte',
)]
class UserCommand extends Command
{
    public function __construct(
        private readonly UserService $userService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('firstname', InputArgument::REQUIRED, 'Argument prénom')
            ->addArgument('lastname', InputArgument::REQUIRED, 'Argument nom')
            ->addArgument('email', InputArgument::REQUIRED, 'Argument email')
            ->addArgument('password', InputArgument::REQUIRED, 'Argument password')
            ->addOption('a', null, InputOption::VALUE_NONE, 'Option Admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $user = new User();
        $user
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($password);
    
        //Test si Admin ou pas
        if ($input->getOption('a')) {
            $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
            $io->note("Création d'un admin");
        }
        else { 
            $user->setRoles(["ROLE_USER"]);
            $io->note("Création d'un user");
        }

        //Ajout de l'utilisateur 
        $this->userService->saveUser($user);

        $io->success('Le compte à été créé avec success');

        return Command::SUCCESS;
    }
}
