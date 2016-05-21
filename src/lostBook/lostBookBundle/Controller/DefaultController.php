<?php

namespace lostBook\lostBookBundle\Controller;

use lostBook\lostBookBundle\Entity\MediaAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lostBook\lostBookBundle\Entity\Annonce;
use lostBook\lostBookBundle\Form\Type\AnnonceType;
use Symfony\Component\HttpFoundation\File;
use lostBook\lostBookBundle\Commons\Routes;
use lostBook\lostBookBundle\Entity\RechercheAnnonces;
use lostBook\lostBookBundle\Form\Type\RechercheAnnoncesType;
use lostBook\lostBookUserBundle\Entity\Utilisateur;

class DefaultController extends Controller {

    public function indexAction() {

        $request = $this->getRequest();
        $session = $request->getSession();
        $homeMessage = $session->get(Routes::$HOME_MESSAGE);
        $afficherRecherche = FALSE;
        if ($session->get('recherche') != null) {
            $recherche = $session->get('recherche');
        } else {
            $recherche = new RechercheAnnonces();
        }
        $form = $this->createForm(new RechercheAnnoncesType(), $recherche);
        $form->handleRequest($request);
        
        $this->updateSessionVariablesBeforeUpdate($session);

        $afterLoginRoute = $session->get('afterLoginRoute');
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');


        if ($form->isValid()) {

            $annonces = $annonceRepository->getResultatRecherche($recherche);
            $session->set('recherche', $recherche);
            $session->set('resultatRechercheAnnonces', $annonces);
            $afficherRecherche = TRUE;
        } else {

            if ($session->get('resultatRechercheAnnonces') != null) {

                $annonces = $session->get('resultatRechercheAnnonces');
            } else {
                $annonces = $annonceRepository->findAll();
            }
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $annonces, $request->query->getInt('page', 1)/* page number */, 6/* limit per page */
        );
        $pagination->setUsedRoute('_lostbook_homepage');


        $session->set(Routes::$HOME_MESSAGE, NULL);
        return $this->render('lostBookBundle:Default:index.html.twig', array('pagination' => $pagination,
                    'message' => $homeMessage,
                    'afficherRecherche' => $afficherRecherche,
                    'form' => $form->createView()));
    }

    /**
     * C'est le controleur qui est appellé pour générer et 
     * afficher le formulaire de création d'une nouvelle 
     * annonce
     * @return type
     */
    public function nouvelleAnnonceAction() {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');

        //On récupère la requête
        $request = $this->getRequest();

        //On crée un nouvel objet annonce, avec ses champs vides
        $annonce = new Annonce();

        //on crée le formulaire en se basant sur l'objet annonce crée précedemment
        $form = $this->createForm(new AnnonceType(), $annonce);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $session = $request->getSession();
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user != 'anon.') {
                $annonce->setUtilisateur($user);
            } else {

                $annonce->setUtilisateur(NULL);
            }

            $annonce->setPerdu(FALSE);
            $annonce->setEtat('0');
            date_default_timezone_set("Africa/Douala");
            //$date = \DateTime::createFromFormat("d-m-Y H:i:s", time());
            $date = new \DateTime("now");
            $annonce->setDateCreation($date);
            $annonce->setNombreVues(0);
            //$espace->setNombreAnnonces($espace->getNombreAnnonces() + 1);
            $espace = $annonce->getEspace();
            if (NULL != $espace) {
                $espace->setNombreAnnonces($espace->getNombreAnnonces() + 1);
            }
            $em = $this->getDoctrine()->getManager();

            $em->persist($annonce);
            $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
            $manager->getFiles();
            $files = $manager->uploadFiles();

            //à ce niveau, on met à jour l'annonce en définissant son image par défaut
            foreach ($files as $document) {
                $tmp = new MediaAnnonce();
                $tmp->file = $document;
                $tmp->setAnnonce($annonce);
                $tmp->preUpload();
                $em->persist($tmp);
                $tmp->upload();
            }
            if (isset($files[0])) {
                $annonce->setImagePrincipale($files[0]->getFileName());
            }

            $em->flush();

            //Ici on met à jour l'objet annonce en lui définissant une image principale
            //$this->rTCMatching($annonce);
            return $this->redirect($this->generateUrl('_lostbook_homepage'));
        } else {

            return $this->render('lostBookBundle:Annonces:publierAnnonce.html.twig', 
                    array('form' => $form->createView()));
        }
    }

    public function newLostAction() {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');

        //On récupère la requête
        $request = $this->getRequest();

        //On crée un nouvel objet annonce, avec ses champs vides
        $annonce = new Annonce();

        //on crée le formulaire en se basant sur l'objet annonce crée précedemment
        $form = $this->createForm(new AnnonceType(), $annonce);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $session = $request->getSession();
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user != 'anon.') {
                $annonce->setUtilisateur($user);
            } else {

                $annonce->setUtilisateur(NULL);
            }

            $annonce->setPerdu(TRUE);
            $annonce->setEtat('0');
            date_default_timezone_set("Africa/Douala");
            $date = \DateTime::createFromFormat("d-m-Y H:i:s", time());
            $annonce->setDateCreation($date);
            $annonce->setNombreVues(0);


            $espace = $annonce->getEspace();
            if (NULL != $espace) {
                $espace->setNombreAnnonces($espace->getNombreAnnonces() + 1);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
            $manager->getFiles();
            $files = $manager->uploadFiles();

            //à ce niveau, on met à jour l'annonce en définissant son image par défaut
            foreach ($files as $document) {
                $tmp = new MediaAnnonce();
                $tmp->file = $document;
                $tmp->setAnnonce($annonce);
                $tmp->preUpload();
                $em->persist($tmp);
                $tmp->upload();
            }
            if (isset($files[0])) {
                $annonce->setImagePrincipale($files[0]->getFileName());
            }

            $em->flush();


            //Ici on met à jour l'objet annonce en lui définissant une image principale
            return $this->redirect($this->generateUrl('_lostbook_homepage'));
        } else {

            return $this->render('lostBookBundle:Annonces:newLost.html.twig', array('form' => $form->createView()));
        }
    }

    public function updateAnnonceAction($idAnnonce) {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');
        $annonceRepository = $this->getDoctrine()->getRepository("lostBookBundle:Annonce");
        $mediaAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaAnnonce');
        
        

        //On récupère la requête
        $request = $this->getRequest();
        
        //on récupère la session et on met à jour toutes les variables nécessaires
        
        $session = $request->getSession();
        //die("forTest");
        $this->updateSessionVariablesBeforeUpdate($session);
        
         
        
        

        //On récupère l'annonce
        $annonce = $annonceRepository->find($idAnnonce);
        $medias = $mediaAnnonceRepository->findBy(array('annonce' => $annonce->getId()));
        $annonce->setMedias($medias);

        //on crée le formulaire en se basant sur l'objet récupéré précédemment
        $form = $this->createForm(new AnnonceType(), $annonce);

        $form->handleRequest($request);

        if ($form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
            $manager->getFiles();
            $files = $manager->uploadFiles();
            
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user != 'anon.') {
                $annonce->setUtilisateur($user);
            } else {

                $annonce->setUtilisateur(NULL);
            }

            //à ce niveau, on met à jour l'annonce en définissant son image par défaut
            foreach ($files as $document) {
                $tmp = new MediaAnnonce();
                $tmp->file = $document;
                $tmp->setAnnonce($annonce);
                $tmp->preUpload();
                $em->persist($tmp);
                $tmp->upload();
            }
            if (isset($files[0])) {
                $annonce->setImagePrincipale($files[0]->getFileName());
            }

            $em->flush();

            $securityBag = $session->get("securityBag");
            $securityBag['codeCreateur'] = FALSE;
            $session->set("securityBag", $securityBag);
            //Ici on met à jour l'objet annonce en lui définissant une image principale
            return $this->redirect($this->generateUrl('_lostbook_homepage'));
        } else {

            return $this->render('lostBookBundle:Annonces:majAnnonce.html.twig', array('form' => $form->createView(),
                        'annonce' => $annonce));
        }
    }

    public function detailsAnnonceAction($idAnnonce) {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
        $mediaAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaAnnonce');
        $session = $this->getRequest()->getSession();
        $annonce = $annonceRepository->find($idAnnonce);
        $nombreVues = $annonce->getNombreVues();
        $nouveauNombreVues = $nombreVues + 1;
        $annonce->setNombreVues($nouveauNombreVues);
        $medias = $mediaAnnonceRepository->findBy(array('annonce' => $annonce->getId()));
        $annonce->setMedias($medias);
        $em->flush();

        /* le code traduit si oui ou non il y'a un problème 
         * 0 pas de problème
         * -1 problème
         */
        $securityBag = $session->get("securityBag");


        $code = isset($securityBag['codeProprietaireAnnonce']) ? $securityBag['codeProprietaireAnnonce'] : 0;
        $message = isset($securityBag['messageProprietaireAnnonce']) ? $securityBag['messageProprietaireAnnonce'] : NULL;

        $securityBag['codeProprietaireAnnonce'] = 0;
        $securityBag['messageProprietaireAnnonce'] = NULL;

        $session->set("securityBag", $securityBag);



        return $this->render('lostBookBundle:Annonces:detailsAnnonce.html.twig', array('annonce' => $annonce,
                    'code' => $code,
                    'message' => $message
        ));
    }
    
    private function updateSessionVariablesBeforeUpdate($session)
    {
        $session->set(Routes::$ORIGIN_ROUTE, NULL);
    }

    public function deleteAnnonceAction($idAnnonce) {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $this->getDoctrine()->getRepository("lostBookBundle:Annonce");
        //On récupère la requête
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->set(Routes::$HOME_MESSAGE, "general.annonce_supprimee");

        //On récupère l'annonce
        $annonce = $annonceRepository->find($idAnnonce);
        $annonce->setEtat("1");
        $espace = $annonce->getEspace();
        if (NULL != $espace) {
            $espace->setNombreAnnonces($espace->getNombreAnnonces() - 1);
        }
        $em->flush();

        return $this->redirectToRoute(Routes::$HOME);
    }
    
    public function faqsAction()
    {
       return $this->render('lostBookBundle:Default:faqs.html.twig');
    }

}
