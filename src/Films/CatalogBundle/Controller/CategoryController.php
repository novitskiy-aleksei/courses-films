<?php

namespace Films\CatalogBundle\Controller;

class CategoryController extends FilmsCatalogBaseController
{
    public function indexAction($id)
    {
        return $this->render('FilmsCatalogBundle:Category:view.html.twig', [
            'category' => $this->get('films_catalog.category_manager')->get($id),
        ]);
    }

    public function removeAction($id)
    {
        $film = $this->get('films_catalog.category_manager')->get($id);

        if (!empty($film)){
            $this->getEntityManager()->remove($film);
            $this->getEntityManager()->flush();
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    public function addAction($data)
    {

    }

}