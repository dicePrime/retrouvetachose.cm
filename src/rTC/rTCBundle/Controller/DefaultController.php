<?php

namespace rTC\rTCBundle\Controller;

use rTC\rTCBundle\Entity\MediaAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use rTC\rTCBundle\Entity\Annonce;
use rTC\rTCBundle\Form\Type\AnnonceType;
use Symfony\Component\HttpFoundation\File;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $annonceRepository = $this->getDoctrine()->getRepository('rTCBundle:Annonce');
        $annonces = $annonceRepository->findAll();
        /*$mediaAnnonceRepository = $this->getDoctrine()->getRepository('rTCBundle:MediaAnnonce');

        foreach($annonces as $annonce)
        {
            $medias = $mediaAnnonceRepository->findBy(array('annonce'=>$annonce->getId()));
            $annonce->setMedias($medias);
        }
        */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $annonces,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('rTCBundle:Default:index.html.twig',array('pagination'=>$pagination));
    }
    
    /**
     * C'est le controleur qui est appellé pour générer et 
     * afficher le formulaire de création d'une nouvelle 
     * annonce
     * @return type
     */
    public function nouvelleAnnonceAction()
    {
        //On récupère la requête
        $request = $this->getRequest();
        
        //On crée un nouvel objet annonce, avec ses champs vides
        $annonce = new Annonce();

        //on crée le formulaire en se basant sur l'objet annonce crée précedemment
       $form = $this->createForm(new AnnonceType(), $annonce);

       $form->handleRequest($request);

       if($form->isValid())
       {

           $session = $request->getSession();
           $user = $this->container->get('security.context')->getToken()->getUser();
           $annonce->setUtilisateur($user);
           $annonce->setPerdu(true);
           $annonce->setEtat('0');
           $date = new \DateTime('tomorrow');
           $annonce->setDateCreation($date);



           $em = $this->getDoctrine()->getManager();

           $em->persist($annonce);
           $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
           $files = $manager->getFiles();
           $files = $manager->uploadFiles();
           
           //à ce niveau, on met à jour l'annonce en définissant son image par défaut
           foreach($files as $document)
           {
               $tmp = new MediaAnnonce();
               $tmp->file = $document;
               $tmp->setAnnonce($annonce);
               $tmp->preUpload();
               $em->persist($tmp);
               $tmp->upload();

           }
           if(isset($files[0]))
           {
               $annonce->setImagePrincipale($files[0]->getFileName());
           }
           
           $em->flush();
           //Ici on met à jour l'objet annonce en lui définissant une image principale
           return $this->redirect($this->generateUrl('r_tc_homepage'));
       }
       else
       {
       return $this->render('rTCBundle:Annonces:nouvelleAnnonce.html.twig',array('form'=>$form->createView()));
       }


    }

    public function detailsAnnonceAction($idAnnonce)
    {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $this->getDoctrine()->getRepository('rTCBundle:Annonce');
        $mediaAnnonceRepository = $this->getDoctrine()->getRepository('rTCBundle:MediaAnnonce');

        $annonce = $annonceRepository->find($idAnnonce);
        $medias = $mediaAnnonceRepository->findBy(array('annonce'=>$annonce->getId()));
        $annonce->setMedias($medias);

        return $this->render('rTCBundle:Annonces:detailsAnnonce.html.twig',array('annonce'=>$annonce));

    }

}
