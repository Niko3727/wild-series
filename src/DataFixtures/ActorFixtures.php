<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create(); 

          for($i = 1; $i <= 10; $i++ ) {
            $actor = new Actor(); 
            $actor->setName($faker->name); 
            $actor->setBirthdate($faker->dateTimeBetween('1970-01-01','2010-01-01'));
            for($j = 1; $j <= 3; $j++ ) {
            $programReference = $this->getReference('program_' . random_int(1, 10));
            $actor->addProgram($programReference);
            }
 
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);

            } 
 
        $manager->flush();
    }
    public function getDependencies()
    {
        //Tu retournes ici toutes les classe de fixtures dont SeasonFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
