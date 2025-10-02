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
use App\ClientsAPI\ClientPokeAPI;
use App\ClientsAPI\RegisterPokemon;

#[AsCommand(
    name: 'app:populate-database',
    description: 'Populate Database Pokemon',
)]
class PopulateDatabaseCommand extends Command
{

    public function __construct(
        private readonly RegisterUserContext $registrationContext,
        private readonly ClientPokeAPI $pokeApi,
        private readonly RegisterPokemon $registerPokemon

    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $pokemons = $this->pokeApi->list();
            $this->registerPokemon->save($pokemons);

            //Create Users
            $professor = $this->makeUserProfessor();
            $this->registrationContext->strategy('PROFESSOR', $professor);

            $trainerOne =  $this->makeUserTrainer();
            $this->registrationContext->strategy('TRAINER', $trainerOne);

            $trainerTwo =  $this->makeUserTrainer();
            $this->registrationContext->strategy('TRAINER', $trainerTwo);

        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

        $output->writeln('<info>Se ha llenado la pokebase!</info>');
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

    private function makeUserTrainer()
    {
        $data = [
            "username" => "trainer_".rand(100, 9999),
            "password" => "12345",
            "roles" => ['ROLE_TRAINER']
        ];

        $userDirectorBuilder = new \App\Builders\UserDirectorBuilder();
        $user = $userDirectorBuilder->build($data, 'PROFESSOR');

        return $user;
    }
}
