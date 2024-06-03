<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
            // Ligne qui définit le nombre de programs = 10
        for($i = 1; $i <= 10; $i++) {
            $programReference = $this->getReference('program_' . $i);
            // Ligne qui définit le nombre de saison = 5
          for($j = 1; $j <= 5; $j++ ) {
            $season = new Season(); 
            $season->setNumber($j); 
            // $season->setYear('200' . $j);
            $season->setYear(($faker->numberBetween(1989,1990)) +$j);
            $season->setDescription($faker->paragraph(2));
            $season->setProgram($programReference);
            $manager->persist($season);

            $this->addReference('season_' . $i . '_' . $j, $season);

            }  
        }   
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
