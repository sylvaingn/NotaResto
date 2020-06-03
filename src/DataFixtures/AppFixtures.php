<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 restaurants
        for ($i = 0; $i < 10; $i++) {
            $restaurant = new Restaurant();
            $restaurant->setNom($faker->company);
            $restaurant->setDescription($faker->text);
            $restaurant->setCreatedAt($faker->dateTime);
            $manager->persist($restaurant);
        }

        $manager->flush();
    }
}
