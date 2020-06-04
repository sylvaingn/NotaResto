<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Repository\RestaurantRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AvisFixtures extends Fixture implements DependentFixtureInterface
{
    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepository, AvisRepository $avisRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->avisRepository = $avisRepository;
    }

    public function load(ObjectManager $manager)
    {


        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 restaurants
        for ($i = 0; $i < 1000; $i++) {
            $avis = new Avis();
            $avis->setCommentaire($faker->text);
            $avis->setNote(rand(0, 10));
            $avis->setCreatedAt($faker->dateTime);
            $avis->setRestaurant($this->restaurantRepository->find(rand(1, 100)));

            $manager->persist($avis);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            AppFixtures::class,
        ];
    }
}
