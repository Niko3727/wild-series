<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;


use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
   
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        for($i = 1; $i <= 10; $i++) {
            $programReference = $this->getReference('program_' . $i);
          for($j = 1; $j <= 5; $j++ ) {
            $seasonReference = $this->getReference('season_' . $i . '_' . $j);
            for($k = 1; $k <= 10; $k++ ) {
            $episode = new Episode(); 
            $episode->setTitle($faker->words(3, true)); 
            $episode->setSynopsis($faker->paragraph(2, true));
            $episode->setNumber($k); 
            $slug = $this->slugger->slug($episode->getTitle());
            $episode->setDuration(($faker->numberBetween(45,55)));
            $episode->setSlug($slug);
            $episode->setSeason($seasonReference);
            $manager->persist($episode);
            } 
            

            }  
        }   
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
