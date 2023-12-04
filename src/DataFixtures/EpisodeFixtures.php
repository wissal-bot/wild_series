<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $season = $this->getReference('season1_existing');

        for ($i = 1; $i <= 3; $i++) {
            $episode = new Episode();
            $episode->setTitle("Episode $i");
            $episode->setNumber($i);
            $episode->setSeason($season($this->getReference($season)));
            $manager->persist($episode);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
          SeasonFixtures::class,
        ];
    }
}
