<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Annonces;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 50 ; $i++) { 
            $annonce = new Annonces();
            $annonce->setTitle($this->faker->word());

            $manager->persist($annonce);
   
        }
       
        
        $manager->flush();
    }
}
