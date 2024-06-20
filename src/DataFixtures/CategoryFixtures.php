<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

use Faker\Factory;

class CategoryFixtures extends Fixture
{

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
   
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 1; $i <= 5; $i++ ) {
            $category = new Category(); 
            $category->setName($faker->word()); 
            $slug = $this->slugger->slug($category->getName());
            $category->setSlug($slug);
            $manager->persist($category);
            $this->addReference('category_' . $i, $category);

        }

        $manager->flush();
    }
}
