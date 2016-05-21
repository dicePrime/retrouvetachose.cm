<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Controller;

/**
 * Description of SecurityController
 *
 * @author ndziePatrick
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lostBook\lostBookBundle\Entity\SaisieCodeCreateur;
use lostBook\lostBookBundle\Form\Type\SaisieCodeCreateurType;
use lostBook\lostBookBundle\Commons\Routes;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends Controller {

    //put your code here

    /**
     * Ce controller gère le formulaire de saisie du 
     * code lié à l'annonce et redirige l'utilisateur vers la correspondante au résultat
     * de la requête
     * @param type $idAnnonce
     * @return type
     */
    public function saisieCodeCreateurAction($idAnnonce) {
        $request = $this->getRequest();
        $session = $request->getSession();

        $originRoute = $session->get(Routes::$ORIGIN_ROUTE);        
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
        $annonce = $annonceRepository->find($idAnnonce);
        $saisieCodeCreateur = new SaisieCodeCreateur();
        $form = $this->createForm(new SaisieCodeCreateurType(), $saisieCodeCreateur);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            
            // on affiche la page de modification de l'annonce
            $conditionCode = $saisieCodeCreateur->getCode() == $annonce->getCodeCreateur();
            $conditionEmail = $saisieCodeCreateur->getEmail() == $annonce->getEmail();

            //die("codeCreateur = " . $annonce->getEmail() . " __ saisie =" . $saisieCodeCreateur->getEmail());

            if ($conditionCode == FALSE || $conditionEmail == FALSE) {
                
                //on réinitialise le conteneur de routes
                $session->set('originRoute',NULL);
                return $this->render('lostBookBundle:Annonces:saisieCodeCreateur.html.twig', array('form' => $form->createView(),
                            'messageCode' => !$conditionCode,
                            'messageEmail' => !$conditionEmail,
                            'annonce' => $annonce));
            } 
            else
                {
                
                $this->manageSecurityBagWhenFormIsValid($session);
                  //on réinitialise le conteneur de routes
                
                //$this->manageRedirectionWhenFormIsValid($session, $annonce, $originRoute);
                if(trim($originRoute) == trim(Routes::$EDITION_ANNONCE))
                {    
                  $session->set('originRoute',NULL);
                  return $this->redirectToRoute(trim(Routes::$EDITION_ANNONCE), array('idAnnonce' => $annonce->getId()));
                }
                else if($originRoute == Routes::$SUPPRIMER_ANNONCE)
                {                    
                    $session->set('originRoute',NULL);
                    return $this->redirectToRoute(Routes::$SUPPRIMER_ANNONCE,array('idAnnonce'=>$annonce->getId()));
                }
            }
        } else {


            $this->manageSecurityBagWhenFormIsNotValid($session);
            return $this->render('lostBookBundle:Annonces:saisieCodeCreateur.html.twig', array('form' => $form->createView(),
                        'messageCode' => FALSE,
                        'messageEmail' => FALSE,
                        'annonce' => $annonce));
        }
    }
    
    private function manageSecurityBagWhenFormIsValid($session)
    {
        if ($session->get("securityBag") != NULL)
                {

                    $securityBag = $session->get("securityBag");
                    $securityBag['codeCreateur'] = TRUE;
                    $session->set("securityBag", $securityBag);
                } else {

                    $securityBag = array(
                        'codeCreateur' => TRUE
                    );
                    $securityBag['codeCreateur'] = TRUE;
                    $session->set("securityBag", $securityBag);
                }   
    }
    
    private function manageSecurityBagWhenFormIsNotValid($session)
    {   
        if ($session->get("securityBag") != NULL)
                {

                    $securityBag = $session->get("securityBag");
                    $securityBag['codeCreateur'] = FALSE;
                    $session->set("securityBag", $securityBag);
                } else {

                    $securityBag = array(
                        'codeCreateur' => FALSE
                    );
                 
                    $session->set("securityBag", $securityBag);
                }   
    }
    
    public function manageRedirectionWhenFormIsValid($session, $annonce,$originRoute)
    {
        
        
         
    }
    
   

}
