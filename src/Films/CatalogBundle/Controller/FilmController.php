<?php

namespace Films\CatalogBundle\Controller;

use Films\CatalogBundle\Entity\Film;
use Films\CatalogBundle\Event\RatingUpdatedEvent;
use Films\CatalogBundle\Event\StoredEvents;
use Films\CatalogBundle\Form\FilmType;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Finder\Exception\AccessDeniedException;

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
     * @throws \Symfony\Component\Finder\Exception\AccessDeniedException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $film = $this->get('films_catalog.film_manager')->get($id);

        if (!empty($film)){

            $securityContext = $this->get('security.context');

            // check for edit access
            if (false === $securityContext->isGranted('DELETE', $film)) {
                throw new AccessDeniedException();
            }

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
     * @internal param array $data
     * @throws \Symfony\Component\Security\Acl\Exception\Exception
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction()
    {
        $film = new Film();

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->get('form.factory')->create(new FilmType(), $film);

        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $director = $this->getEntityManager()
                    ->getRepository('FilmsCatalogBundle:Director')
                    ->findOneById($film->getDirector()->getId());
                $film->setDirector($director);

                $this->getEntityManager()->persist($film);
                $this->getEntityManager()->flush();

                // creating the ACL
                $aclProvider = $this->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($film);
                $acl = $aclProvider->createAcl($objectIdentity);

                // retrieving the security identity of the currently logged-in user
                $securityContext = $this->get('security.context');
                $user = $securityContext->getToken()->getUser();
                $securityIdentity = UserSecurityIdentity::fromAccount($user);

                // grant owner access
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
            }
        } else {
            throw new Exception('Form is not valid');
        }

        return $this->redirect($this->generateUrl('homepage'));
    }
}