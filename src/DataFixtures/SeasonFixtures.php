<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $season = new Season();
        $season->setNumber(1);
        $season->setYear(1989);
        $season->setDescription("Sydney Bristow travaille comme espionne pour une branche secrète de la CIA");
        $season->setProgram($this->getReference('program_Alias'));
        $this->addReference('season1_Alias', $season);
        $manager->persist($season);

        $manager->flush();

    }
    public function getDependencies()
    {
        //Tu retournes ici toutes les classe de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
