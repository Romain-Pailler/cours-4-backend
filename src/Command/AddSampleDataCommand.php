<?php

namespace App\Command;

use App\Entity\Building;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-sample-data',
    description: 'Add a sample data for your dbs',
)]

class AddSampleDataCommand extends Command
{
    protected static string $defaultName = 'app:add-sample-data';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $building = new Building();
            $building->setName($faker->company);
            $this->entityManager->persist($building);

            for ($j = 1; $j <= 10; $j++) {
                $person = new Person();
                $person->setName($faker->name);
                $person->setEmail($faker->email);
                $person->setBuilding($building);
                $this->entityManager->persist($person);
            }
        }

        $this->entityManager->flush();
        $output->writeln('Données ajoutées !!');
        return Command::SUCCESS;
    }
}
