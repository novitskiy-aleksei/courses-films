<?php

namespace Films\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Films\CatalogBundle\Entity\Film;


class LoadFilm implements FixtureInterface, OrderedFixtureInterface{

    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $director = $manager
            ->getRepository('FilmsCatalogBundle:Director')
            ->findOneById(1)
        ;
        $actor = $manager
            ->getRepository('FilmsCatalogBundle:Actor')
            ->findOneById(1)
        ;

        $category = $manager
            ->getRepository('FilmsCatalogBundle:Category')
            ->findOneById(1)
        ;

        $film = new Film();

        $film->populate([
            'director'    => $director,
            'title'       => 'Мстители',
            'description' => '',
            'date'        => new \DateTime('2012-11-03'),
            'rating'      => 0,
            'active'      => 1,
            'picture'     => 'http://st.kinopoisk.ru/images/film_big/263531.jpg',
        ]);
        
        $film->addActor($actor);
        $film->addCategory($category);

        $manager->persist($film);

        $manager->flush();
    }
} 