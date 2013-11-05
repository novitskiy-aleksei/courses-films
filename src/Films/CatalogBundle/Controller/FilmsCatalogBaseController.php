<?php

namespace Films\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FilmsCatalogBaseController extends Controller
{
    public function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }
}