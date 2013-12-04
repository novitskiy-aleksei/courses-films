<?php

namespace Films\CatalogBundle\Controller;

use Films\CatalogBundle\Entity\Film;
use Films\CatalogBundle\Event\RatingUpdatedEvent;
use Films\CatalogBundle\Event\StoredEvents;
use Films\CatalogBundle\Form\FilmType;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FilmController extends FilmsCatalogBaseController
{
    /**
     * View film card
     *
     * @param $id integer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener(StoredEvents::RATING_UPDATED, function (RatingUpdatedEvent $event) {
            $entity = $event->getEntry();
            $entity->setRating($event->getScore());
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        });

        $film = new Film();
        $event = new RatingUpdatedEvent($film, 7);
        $dispatcher->dispatch(StoredEvents::RATING_UPDATED, $event);

        return $this->render('FilmsCatalogBundle:Film:view.html.twig', [
            'film' => $this->get('films_catalog.film_manager')->get($id),
        ]);
    }

    /**
     * Create new Film item
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $form = $this->createForm(new FilmType());

        return $this->render('FilmsCatalogBundle:Film:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete film item
     *
     * @param $id integer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $film = $this->get('films_catalog.film_manager')->get($id);

        if (!empty($film)){
            $this->getEntityManager()->remove($film);
            $this->getEntityManager()->flush();
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * Add new film entity
     *
     * (for testing purposes)
     *
     * @param $data array
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
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