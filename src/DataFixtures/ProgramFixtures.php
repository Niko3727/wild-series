<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

use Faker\Factory;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i =1; $i <= 10; $i++) {
            $program = new Program();
            $program->setTitle($faker->words(3, true)); 
            $program->setSynopsis($faker->paragraphs(2, true));
            $program->setPoster($faker->imageurl(500, 500, 'Affiche'));
            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $program->setCategory($this->getReference('category_' . $faker->numberBetween(1, 5)));
            $manager->persist($program);

            $this->addReference('program_' .$i, $program);

        }
       
        $manager->flush();
        
    }
    public function getDependencies()
    {
        //Tu retournes ici toutes les classe de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
