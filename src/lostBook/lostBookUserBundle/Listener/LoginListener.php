<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookUserBundle\Listener;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use lostBook\lostBookBundle\Commons\Routes;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of LoginListener
 *
 * @author ndziePatrick
 */
class LoginListener {
    //put your code here
    /** @var \Symfony\Component\Security\Core\SecurityContext */
    private $securityContext;
   
    private $container;
    
 
    
    /**
     * Constructor
     *
     * @param SecurityContext $securityContext
     * @param Doctrine        $doctrine
     */
    public function __construct(Container $container,SecurityContext $securityContext)
    {
        $this->container = $container;
        $this->securityContext = $securityContext;
        $this->router = $container->get('router');
        
    }

  

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        
        $user = $event->getAuthenticationToken()->getUser();
        $request = $event->getRequest();

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            // user has just logged in
            $this->redirectTo($request, $event);
            
        }
    }

    /**
     * 
     * @param type $request
     * @param type $user
     */
    public function redirectTo($request,$event){
        
        $session = $request->getSession();
        $afterLoginRoute = $session->get(Routes::$AFTER_LOGIN_ROUTE);
        
        $afterLoginParameters = $session->get(Routes::$AFTER_LOGIN_PARAMETERS);
        
        print_r($afterLoginParameters);
       
        
        $idAnnonce = isset($afterLoginParameters['idAnnonce']) ? $afterLoginParameters['idAnnonce'] : NULL;
        
        //print_r($afterLoginRoute.'-'.Routes::$EDITION_ANNONCE);
        
        //print_r($idAnnonce);
        //die($idAnnonce);
        
        if($afterLoginRoute == Routes::$EDITION_ANNONCE && NULL !=  $idAnnonce)
        {           
          
          return new RedirectResponse($this->router->generate(Routes::$EDITION_ANNONCE, array('idAnnonce' => $idAnnonce)));
        }
    }
}
