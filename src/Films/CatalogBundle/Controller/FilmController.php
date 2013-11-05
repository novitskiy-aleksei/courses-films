<?php

namespace Films\CatalogBundle\Controller;

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


}