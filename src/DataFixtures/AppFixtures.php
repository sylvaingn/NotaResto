<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private $villeRepository;

    public function __construct( VilleRepository $villeRepository)
    {
        $this->villeRepository = $villeRepository;
    }
    
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 restaurants
        for ($i = 0; $i < 100; $i++) {
            $restaurant = new Restaurant();
            $restaurant->setNom($faker->company);
            $restaurant->setDescription($faker->text);
            $restaurant->setCreatedAt($faker->dateTime);
            $restaurant->setVille($this->villeRepository->find(rand(1,1000)));

            $manager->persist($restaurant);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
        ];
    }
}
