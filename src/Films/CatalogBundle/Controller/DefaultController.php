<?php

namespace Films\CatalogBundle\Controller;

class DefaultController extends FilmsCatalogBaseController
{
    public function indexAction()
    {
        return $this->render('FilmsCatalogBundle:Default:index.html.twig', [
            'topList'       => $this->get('films_catalog.film_manager')->getTopList(),
            'topCategory'   => $this->get('films_catalog.film_manager')->getTopList()
        ]);
    }

    public function s()
    {

    }
}