<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (ProgramFixtures::PROGRAMS as $key => $programData) {
            for ($i= 1; $i <= 5; $i++) {
        $season = new Season();
        $season ->setNumber($faker->numberBetween(1, 5))
                ->setProgram($this->getReference('program_' . $programData['title']));
        $this->addReference('season_' . $i . '_' . $key, $season);
        $manager->persist($season);
            }
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class,
        ];
    }
}