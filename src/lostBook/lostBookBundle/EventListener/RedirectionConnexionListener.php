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
    
    
   
    public function __construct(ContainerInterface $container, Session $session) {
        
        $this->session  = $session;
        $this->router = $container->get('router');
        $this->securityContext = $container->get('security.context');
        
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        
        
       if($route == '_lostbook_homepage')
        {
            
            if($event->getRequest()->get('page') == null)
            {
                $this->session->set('resultatRechercheAnnonces',null);
                $this->session->set('resultatRechercheEspaces',null);
                $this->session->set('recherche',null);
            }
        }
        if($route == Routes::$NOUVEL_ESPACE_ROUTE)
        {
            if(!is_object($this->securityContext->getToken()->getUser()))
            {
                $this->session->set('afterLoginRoute',Routes::$NOUVEL_ESPACE_ROUTE);
                $this->session->getFlashBag()->add('Notification','Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }
}
