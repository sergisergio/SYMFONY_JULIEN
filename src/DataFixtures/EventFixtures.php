<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Event;

class EventFixtures extends Fixture
{
    private $manager;
    private $faker;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = factory::create();
        $this->addFaker(30);
        $this->manager->flush();
    }

    private function addFaker($nb)
    {
        while($nb > 0)
        {
            $event = new Event();
            $event->setName($this->faker->name);
            $event->setPrice($this->faker->randomFloat(5,100,999));
            $event->setDate($this->faker->dateTimeBetween('now', '+5 years'));
            $event->setDescription($this->faker->text());
            $event->setLocation($this->faker->address);
            $this->manager->persist($event);
            $nb--;
        }
    }
}
