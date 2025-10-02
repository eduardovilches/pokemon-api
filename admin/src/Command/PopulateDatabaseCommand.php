<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Strategy\Register\RegisterUserContext;
use App\Entity\User;
use Doctrine\DBAL\Exception as DBALException;


#[AsCommand(
    name: 'app:populate-database',
    description: 'Populate Database Pokemon',
)]
class PopulateDatabaseCommand extends Command
{
    public function __construct(
        private readonly RegisterUserContext $registrationContext
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $professor = $this->makeUserProfessor();

            $this->registrationContext->strategy('PROFESSOR', $professor);
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

        return Command::SUCCESS;
    }

    private function makeUserProfessor()
    {
        $data = [
            "username" => "professor_user",
            "password" => "1234",
            "roles" => ['ROLE_PROFESSOR']
        ];

        $userDirectorBuilder = new \App\Builders\UserDirectorBuilder();
        $user = $userDirectorBuilder->build($data, 'PROFESSOR');

        return $user;
    }
}
