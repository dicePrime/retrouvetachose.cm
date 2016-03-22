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

    public function saisieCodeCreateurAction($idAnnonce) {
        $request = $this->getRequest();
        $session = $request->getSession();

        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
        $annonce = $annonceRepository->find($idAnnonce);
        

        $saisieCodeCreateur = new SaisieCodeCreateur();
        $form = $this->createForm(new SaisieCodeCreateurType(), $saisieCodeCreateur);
        $form->handleRequest($request);
        if ($form->isValid()) {
            // on affiche la page de modification de l'annonce
            $messageEmail = false;
            $messageCode = false;
            $conditionCode = $saisieCodeCreateur->getCode() == $annonce->getCodeCreateur();
            $conditionEmail = $saisieCodeCreateur->getEmail() == $annonce->getEmail();

            if ($conditionCode == false) {
                $messageCode = true;
            }
            if ($conditionEmail == false) {
                $messageEmail = true;
            }
            if (trim($saisieCodeCreateur->getCode()) != trim($annonce->getCodeCreateur()) || trim($saisieCodeCreateur->getEmail()) != trim($annonce->getEmail())) 
                {
                die("ok");
                return $this->render('lostBookBundle:Annonces:saisieCodeCreateur.html.twig', array('form' => $form->createView(),
                            'messageCode' => TRUE,
                            'messageEmail' => TRUE,
                            'annonce' => $annonce));
            } else {
                
                return $this->redirectToRoute('_lostbook_update_annonce', array('idAnnonce' => $annonce->getId()));
            }
        } else {
            $messageEmail = false;
        $messageCode = false;
            // on reste sur la page avec un message d'erreur  
            return $this->render('lostBookBundle:Annonces:saisieCodeCreateur.html.twig', array('form' => $form->createView(),
                        'messageCode' => $messageCode,
                        'messageEmail' => $messageEmail,
                        'annonce' => $annonce));
        }
    }

}
