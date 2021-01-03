<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use  Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i <= 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program_'. rand(0,5)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);

        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProgramFixtures::class];
    }
}