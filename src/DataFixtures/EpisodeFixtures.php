<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $episode = new Episode();
        $episode->setTitle('Agent double');
        $episode->setSynopsis("Sydney Bristow est une jeune étudiante.");
        $episode->setNumber(1);
        $episode->setSeason($this->getReference('season1_Alias'));
        $manager->persist($episode);

        $manager->flush();

    }
    public function getDependencies()
    {
        //Tu retournes ici toutes les classe de fixtures dont SeasonFixtures dépend
        return [
            SeasonFixtures::class,
        ];
    }
}
