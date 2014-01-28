<?php

namespace Films\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Films\CatalogBundle\Entity\Film;
use Films\CatalogBundle\Entity\User;


class LoadUser implements FixtureInterface, OrderedFixtureInterface{

    public function getOrder()
    {
        return 4;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail('admin@admin.com');
        $user->setEmailCanonical('admin@admin.com');
        $user->setEnabled(true);
        $user->setPlainPassword('admin');
        $user->setSuperAdmin(true);
        $user->setUsername('admin');
        $user->setUsernameCanonical('admin');
        $user->addRole('ROLE_ADMIN');
        $manager->persist($user);

        $manager->flush();
    }
}