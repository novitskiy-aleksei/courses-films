<?php

namespace Films\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Films\CatalogBundle\Entity\Actor;

class LoadActor implements FixtureInterface, OrderedFixtureInterface{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $actor = new Actor();

        $actor->populate([
            'firstname' => 'Винни',
            'lastname'  => 'Джонс',
            'birthdate' => new \DateTime('1979-11-03')
        ]);

        $manager->persist($actor);

        $manager->flush();
    }
} 