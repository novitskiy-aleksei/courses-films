<?php

namespace Films\CatalogBundle\Services;

use Doctrine\ORM\EntityRepository;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;

class FilmsService {

    protected $film;

    public function __construct(EntityRepository $filmRepository)
    {
        $this->film = $filmRepository;
    }

    public function getTopList()
    {
        return $this->film->findBy(['active' => '1'], ['rating' => 'desc']);
    }

    public function get($id)
    {
        return $this->film->findOneBy(['active' => '1', 'id' => $id]);
    }
} 