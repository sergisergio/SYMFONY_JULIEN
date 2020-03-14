<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Advert;
use App\Entity\AdvertSkill;
use App\Entity\Image;
use App\Entity\Application;
use App\Entity\Skill;

class AdvertFixtures extends Fixture
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
        $skills = ['HTML & CSS','JAVASCRIPT','PHP','MYSQL','ANGULAR','SYMFONY'];
        $skillsCollection = [];
        foreach ($skills as $name)
        {
            $skill = new Skill();
            $skill->setName($name);
            array_push($skillsCollection, $skill);
            $this->manager->persist($skill);
        }

        while($nb > 0)
        {   
            $image = new Image();
            $image->setUrl('http://lorempixel.com/200/200/people/' . rand(1,10));
            $image->setAlt($this->faker->text());

            $advert = new Advert();
            $advert->setTitle($this->faker->sentence());
            $advert->setAuthor($this->faker->name);
            $advert->setContent($this->faker->text(rand(1000,2000)));
            $advert->setPublished(rand(0,1));
            $advert->setImage($image);
            for ($i=0; $i < rand(0, count($skills) - 1 ); $i++)
            {
                $advertSkill = new AdvertSkill();
                $advertSkill->setAdvert($advert);
                $advertSkill->setSkill($skillsCollection[$i]);
                $advertSkill->setLevel(rand(1,5));
                $advert->addSkill($advertSkill);
            }            

            if ($advert->getPublished())
            {
                $nbApp = rand(0,5);
                while($nbApp > 0)
                {
                    $application = new Application();
                    $application->setAuthor($this->faker->name);
                    $application->setContent($this->faker->text(rand(250,500)));
                    $advert->addApplication($application);
                    $nbApp--;
                }
            }

            $this->manager->persist($advert);
            $nb--;
        }
    }
}
