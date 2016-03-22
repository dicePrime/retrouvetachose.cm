<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookUserBundle\Controller;

/**
 * Description of ProfileController
 *
 * @author ndziePatrick
 */


use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends BaseController {
    //put your code here
    
    /**
     * Show the user
     */
    public function showAction()
    {
        $request = $this->getRequest();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $annonces = $user->getAnnonces();
         $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
            $annonces,
            $request->query->getInt('page', 1)/*page number*/,
            100/*limit per page*/
        );
            
        $espaces = $user->getEspaces();
        
        $paginationEspaces = $paginator->paginate(
            $espaces,
            $request->query->getInt('page', 1)/*page number*/,
            100/*limit per page*/
        );

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'pagination'=>$pagination,
            'paginationEspaces'=>$paginationEspaces
        ));
    }
}
