<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $customer = new Customer(
                firstName: $faker->firstName(),
                lastName: $faker->lastName(),
                email: $faker->email(),
                phoneNumber: $faker->phoneNumber()
            );
            $manager->persist($customer);
        }

        $manager->flush();
    }
}
