<?php

namespace lostBook\lostBookBundle\EventListener;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedirectionConnexionListener
 *
 * @author ndziePatrick
 */
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use lostBook\lostBookBundle\Commons\Routes;

class RedirectionConnexionListener {

    //put your code here


    private $container;

    public function __construct(ContainerInterface $container, Session $session) {

        $this->container = $container;
        $this->session = $session;
        $this->router = $container->get('router');
        $this->securityContext = $container->get('security.context');
        $this->securityBag = $session->get('securityBag') == NULL ? array() : $session->get('securityBag');
    }

    private function homePageRouteHandler($route, $event) {
        if ($route == Routes::$HOME) {

            if ($event->getRequest()->get('page') == null) {
                $this->session->set('resultatRechercheAnnonces', null);
                $this->session->set('resultatRechercheEspaces', null);
                $this->session->set('recherche', null);
                $this->session->set('rechercheEspaces', null);
            }
        }
    }

    private function nouvelEspaceRouteHandler($route, $event) {
        if ($route == Routes::$NOUVEL_ESPACE_ROUTE) {
            if (!is_object($this->securityContext->getToken()->getUser())) {
                $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }
    
    private function AnnonceRouteHandler($route, $event)
    {
        if($route == Routes::$NOUVELLE_ANNONCE || $route == Routes::$DETAILS_ANNONCE || $route == Routes::$NEW_LOST)
        {
            if(!is_object($this->securityContext->getToken()->getUser()))
            {
               
                $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login'))); 
            }
        }
            
    }

   /* private function editionAnnonceWithCode($event, $annonce) {
        $condition = (!isset($this->securityBag['codeCreateur'])) || $this->securityBag['codeCreateur'] == NULL || false == $this->securityBag['codeCreateur'];

        if ($condition) {
           
            $this->session->set(Routes::$ORIGIN_ROUTE, Routes::$EDITION_ANNONCE);            
            $event->setResponse(new RedirectResponse($this->router->generate('_lostbook_saisie_code_createur', array('idAnnonce' => $annonce->getId()))));
        }
        else
        {
          
        }
    }

    private function editionAnnonceWithoutCode($event, $annonce) {

        if (is_object($this->securityContext->getToken()->getUser())) {
            if ($annonce->getUtilisateur() != $this->securityContext->getToken()->getUser()) {

                $this->securityBag['codeProprietaireAnnonce'] = -1;
                $this->securityBag['messageProprietaireAnnonce'] = "details_annonce.message_proprietaire_annonce";
                $this->session->set("securityBag", $this->securityBag);

                $event->setResponse(new RedirectResponse(
                        $this->router->generate('_lostbook_details_annonce', array('idAnnonce' => $annonce->getId()))));
            }
        } else {
            $this->session->set(Routes::$AFTER_LOGIN_ROUTE, Routes::$EDITION_ANNONCE);
            $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
            $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
        }
    }

    private function editionAnnonceHandler($route, $event) {
        if ($route == Routes::$EDITION_ANNONCE) {
            
            
            $idAnnonce = $event->getRequest()->attributes->get('idAnnonce');

            $annonceRepository = $this->container->get('doctrine')->getRepository("lostBookBundle:Annonce");

            $annonce = $annonceRepository->find($idAnnonce);

            if ($annonce->getUtilisateur() != NULL) {
                $this->editionAnnonceWithoutCode($event, $annonce);
            } else {
                $this->editionAnnonceWithCode($event, $annonce);
            }
        }
    }

    private function suppressionAnnonceHandler($route, $event) {
        if ($route == Routes::$SUPPRIMER_ANNONCE) {


            $idAnnonce = $event->getRequest()->attributes->get('idAnnonce');

            $annonceRepository = $this->container->get('doctrine')->getRepository("lostBookBundle:Annonce");

            $annonce = $annonceRepository->find($idAnnonce);

            if ($annonce->getUtilisateur() != NULL) {
                $this->deleteAnnonceWithoutCode($event, $annonce);
            } else {
                $this->deleteAnnonceWithCode($event, $annonce);
            }
        }
    }

    public function editionEspaceHandler($route, $event) {
        if ($route == Routes::$EDITION_ESPACE) {


            $idEspace = $event->getRequest()->attributes->get('idEspace');

            $espaceRepository = $this->container->get('doctrine')->getRepository("lostBookBundle:Espace");

            $espace = $espaceRepository->find($idEspace);
            if (!is_object($this->securityContext->getToken()->getUser())) {
                $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            } else if ($espace->getAdministrateur() != $this->securityContext->getToken()->getUser()) {
                $this->securityBag['codeProprietaireEspace'] = -1;
                $this->securityBag['messageProprietaireEspace'] = "details_annonce.message_proprietaire_espace";
                $this->session->set("securityBag", $this->securityBag);

                $event->setResponse(new RedirectResponse(
                        $this->router->generate('_lostbook_details_espace', array('idEspace' => $espace->getId()))));
            }
        }
    }

    public function suppressionEspaceHandler($route, $event) {
        if ($route == Routes::$SUPPRIMER_ESPACE) {


            $idEspace = $event->getRequest()->attributes->get('idEspace');

            $espaceRepository = $this->container->get('doctrine')->getRepository("lostBookBundle:Espace");

            $espace = $espaceRepository->find($idEspace);
            if (!is_object($this->securityContext->getToken()->getUser())) {
                $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            } else if ($espace->getAdministrateur() != $this->securityContext->getToken()->getUser()) {
                $this->securityBag['codeProprietaireEspace'] = -1;
                $this->securityBag['messageProprietaireEspace'] = "details_annonce.message_proprietaire_espace";
                $this->session->set("securityBag", $this->securityBag);

                $event->setResponse(new RedirectResponse(
                        $this->router->generate('_lostbook_details_espace', array('idEspace' => $espace->getId()))));
            }
        }
    }*/

    public function onKernelRequest(GetResponseEvent $event) {


        $route = $event->getRequest()->attributes->get('_route');
        $this->session = $event->getRequest()->getSession();

        $this->homePageRouteHandler($route, $event);
        $this->nouvelEspaceRouteHandler($route, $event);
        //$this->nouvellePerteHandler($route, $event);
        //$this->editionAnnonceHandler($route, $event);
        //$this->suppressionAnnonceHandler($route, $event);
        //$this->editionEspaceHandler($route, $event);
        //$this->suppressionEspaceHandler($route, $event);
        $this->AnnonceRouteHandler($route, $event);
    }

   /* public function nouvellePerteHandler($route, $event) {
        if ($route == Routes::$NEW_LOST) {
            if (!is_object($this->securityContext->getToken()->getUser())) {
                $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }

    public function deleteAnnonceWithCode($event, $annonce) {
        $condition = !isset($this->securityBag['codeCreateur']) || $this->securityBag['codeCreateur'] == NULL || FALSE == $this->securityBag['codeCreateur'];

        if ($condition) {
            $this->session->set(Routes::$ORIGIN_ROUTE, Routes::$SUPPRIMER_ANNONCE);
            $event->setResponse(new RedirectResponse($this->router->generate('_lostbook_saisie_code_createur', array('idAnnonce' => $annonce->getId()))));
        }
    }

    public function deleteAnnonceWithoutCode($event, $annonce) {
        if (is_object($this->securityContext->getToken()->getUser())) {
            if ($annonce->getUtilisateur() != $this->securityContext->getToken()->getUser()) {

                $this->securityBag['codeProprietaireAnnonce'] = -1;
                $this->securityBag['messageProprietaireAnnonce'] = "details_annonce.message_proprietaire_annonce";
                $this->session->set("securityBag", $this->securityBag);

                $event->setResponse(new RedirectResponse(
                        $this->router->generate('_lostbook_details_annonce', array('idAnnonce' => $annonce->getId()))));
            }
            // sinon on ne fait rien on supprime tout simplement l'annonce
        } else {
            //$this->session->set(Routes::$AFTER_LOGIN_ROUTE,Routes::$HOME);
            $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
            $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
        }
    }*/

}
