<?php

namespace Films\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Films\CatalogBundle\Entity\Director;

class LoadDirector implements FixtureInterface, OrderedFixtureInterface{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $director = new Director();

        $director->populate([
            'firstname' => 'Гай',
            'lastname'  => 'Ритчи',
            'birthdate' => new \DateTime('1979-11-03')
        ]);

        $manager->persist($director);

        $manager->flush();
    }
} 