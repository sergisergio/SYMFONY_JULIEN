<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Movie;

class MovieFixtures extends Fixture
{
    private $manager;
    private $faker;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = factory::create();
        $this->addFaker(10);
        $this->manager->flush();
    }

    private function addFaker($nb)
    {
        while($nb > 0)
        {
            $movie = new Movie();
            $movie->setTitle($this->faker->company);
            $movie->setDate($this->faker->dateTimeBetween('now','+1 years'));
            $movie->setDirector($this->faker->name());
            $cast = [];
            $loop = rand(5,10);
            for ($i=0; $i < $loop; $i++) {
                $cast[] = $this->faker->company;
            }
            $movie->setCast($cast);
            $this->manager->persist($movie);
            $nb--;
        }
    }
}
