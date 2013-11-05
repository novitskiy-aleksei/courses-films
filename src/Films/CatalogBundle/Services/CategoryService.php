<?php

namespace Films\CatalogBundle\Services;

use Doctrine\ORM\EntityRepository;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;

class CategoryService {

    protected $category;

    public function __construct(EntityRepository $categoryRepository)
    {
        $this->category = $categoryRepository;
    }

    public function getTopList()
    {
        return $this->category->findBy(['active' => '1'], ['rating' => 'desc']);
    }

    public function get($id)
    {
        return $this->category->findOneBy(['active' => '1', 'id' => $id]);
    }
} 