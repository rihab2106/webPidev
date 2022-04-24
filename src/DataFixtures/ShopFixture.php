<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker= Factory::create('en_US');
        for ($i=0; $i<100;$i++){
        $product = new Product();
        $product ->setProdName($faker->words(3,true))
        ->setDescription($faker->sentences(3,true))
        ->setPrice($faker->numberBetween(20,350));
    }
        // $product = new Product();
         $manager->persist($product);

        $manager->flush();
    }
}
