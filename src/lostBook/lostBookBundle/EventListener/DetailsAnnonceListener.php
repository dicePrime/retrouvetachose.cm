<?php

/*
 *Si la route courante correspond à la route
 * qui permet d'afficher les détails d'une annonce
 * alors on récupère l'id de l'annonce, 
 */

namespace lostBook\lostBookBundle\EventListener;

/**
 * Description of DetailsAnnonceListener
 *
 * @author ndziePatrick
 */


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use lostBook\lostBookBundle\Commons\Routes;
class DetailsAnnonceListener {
    //put your code here
     public function __construct(ContainerInterface $container, Session $session) {
        
        $this->session  = $session;
        $this->router = $container->get('router');
        $this->securityContext = $container->get('security.context');
        
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        
        
        if($route == Routes::$NOUVEL_ESPACE_ROUTE || $route == Routes::$EDITION_ANNONCE)
        {
           /* if(!is_object($this->securityContext->getToken()->getUser()))
            {
                $this->session->set('afterLoginRoute',Routes::$NOUVEL_ESPACE_ROUTE);
                $this->session->getFlashBag()->add('Notification','Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }*/
        }
        
    }
}
