<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Assume that 'program_existing' is the reference for your existing program
        $program = $this->getReference('program_existing');

        $season = new Season();
        $season->setNumber(1);
        $season->setProgram($program);
        $manager->persist($season);
        $this->addReference('season1_existing', $season);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }
}
