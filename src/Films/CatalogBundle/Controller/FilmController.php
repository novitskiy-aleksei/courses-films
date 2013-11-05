<?php

namespace Films\CatalogBundle\Controller;

use Films\CatalogBundle\Entity\Film;

class FilmController extends FilmsCatalogBaseController
{
    public function indexAction($id)
    {
        return $this->render('FilmsCatalogBundle:Film:view.html.twig', [
            'film' => $this->get('films_catalog.film_manager')->get($id),
        ]);
    }

    public function removeAction($id)
    {
        $film = $this->get('films_catalog.film_manager')->get($id);

        if (!empty($film)){
            $this->getEntityManager()->remove($film);
            $this->getEntityManager()->flush();
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    public function addAction($data)
    {
        $film = new Film();

        $film->populate($data);
        $director = $this->getEntityManager()
            ->getRepository('FilmsCatalogBundle:Director')
            ->findOne($data['director']['id']);
        $film->setDirector($director);

        $this->getEntityManager()->persist($film);
        $this->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('homepage'));
    }
}