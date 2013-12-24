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

        $cats = [
            [
                'title'       => 'Экшн/Боевик',
                'description' => 'Фильмы для настоящих мужчин',
                'rating'      => 0,
                'active'      => 1
            ],
            [
                'title'       => 'Драма',
                'description' => 'Фильмы для настоящих женщин',
                'rating'      => 0,
                'active'      => 1
            ],
            [
                'title'       => 'Комедия',
                'description' => '',
                'rating'      => 0,
                'active'      => 1
            ],
            [
                'title'       => 'Нацистские приключения',
                'description' => 'Фильмы',
                'rating'      => 0,
                'active'      => 1
            ]
        ];

        foreach($cats as $cat) {
            $category = new Category();

            $category->populate($cat);

            $manager->persist($category);
        }

        $manager->flush();
    }
} 