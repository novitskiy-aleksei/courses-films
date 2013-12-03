<?php

namespace Films\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Films\CatalogBundle\Entity\Category;

class LoadCategory implements FixtureInterface, OrderedFixtureInterface{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $category = new Category();

        $category->populate([
            'title'       => 'Экшн/Боевик',
            'description' => 'Фильмы для настоящих мужчин',
            'rating'      => 0,
            'active'      => 1
        ]);

        $manager->persist($category);

        $manager->flush();
    }
} 