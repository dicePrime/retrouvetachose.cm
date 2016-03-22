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
    }

    public function onKernelRequest(GetResponseEvent $event) {
        
       $route = $event->getRequest()->attributes->get('_route');

        if ($route == '_lostbook_homepage') {

            if ($event->getRequest()->get('page') == null) {
                $this->session->set('resultatRechercheAnnonces', null);
                $this->session->set('resultatRechercheEspaces', null);
                $this->session->set('recherche', null);
                $this->session->set('rechercheEspaces', null);
            }
        }
        if ($route == Routes::$NOUVEL_ESPACE_ROUTE) {
            if (!is_object($this->securityContext->getToken()->getUser())) {
                $this->session->set('afterLoginRoute', Routes::$NOUVEL_ESPACE_ROUTE);
                $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        } 
        else if ($route == Routes::$EDITION_ANNONCE) {
            $idAnnonce = $event->getRequest()->attributes->get('idAnnonce');

            $annonceRepository = $this->container->get('doctrine')->getRepository("lostBookBundle:Annonce");

            $annonce = $annonceRepository->find($idAnnonce);
            
            //si l'utilisateur n'est pas connecté
            if (!is_object($this->securityContext->getToken()->getUser())) {
                
               
                if ($annonce->getUtilisateur() != null) {

                    $this->session->getFlashBag()->add('Notification', 'Vous devez vous identifier');
                    $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
                }
                 //Si l'annonce n'est associée à aucun utilisateur, on affiche
                //la page dans laquelle on doit rentre l'email et le code de l'annonce.
                else {
                //$event->setResponse(new RedirectResponse($this->router->generate('_lostbook_saisie_code_createur',array('idAnnonce'=>$annonce->getId()))));
                }
            } else {
                if ($this->securityContext->getToken()->getUser() != $annonce->getUtilisateur()) {
                     $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
                }
            }
        }
    }

}
