<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR'); // pour mettre la table en français

        for ($i = 0; $i < 100; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->realtext('20'))
                ->setDescription($faker->realtext($faker->numberBetween(50, 100)))
                ->setAuthor($faker->name())
                ->setIsPublished($faker->boolean())
                ->setDateCreated(new \DateTime())
                ->setDateUpdated($faker->dateTimeBetween($wish->getDateCreated(),'+1 day'));
            $manager->persist($wish);
        }

        $manager->flush();
    }
}
