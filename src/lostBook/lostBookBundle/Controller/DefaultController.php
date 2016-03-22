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

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if($session->get('recherche') != null)
        {
            $recherche = $session->get('recherche');
        }
        else
        {
            $recherche = new RechercheAnnonces();
        }
        $form = $this->createForm(new RechercheAnnoncesType(), $recherche);
        $form->handleRequest($request);
        
         
         $afterLoginRoute = $session->get('afterLoginRoute');
         $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
            
        
        if($form->isValid())
        {
           $idText = $recherche->getEspace();
           $idTextArray = preg_split("#-#", $idText);
           if(isset($idTextArray[0]))
           {
               $idEspace = preg_replace('/\s+/', '', $idTextArray[0]);
           }
           
            
            $recherche->setEspace($idEspace);
            $annonces = $annonceRepository->getResultatRecherche($recherche);
            $session->set('recherche',$recherche);
            $session->set('resultatRechercheAnnonces',$annonces);
            
        }
        else
        {      
           
            if($session->get('resultatRechercheAnnonces') != null)
            {
                
                $annonces = $session->get('resultatRechercheAnnonces');
            }
            else
            {
                $annonces = $annonceRepository->findAll();     
            }
                      
        }
        $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
            $annonces,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
            $pagination->setUsedRoute('_lostbook_homepage');
        
        if($afterLoginRoute == Routes::$NOUVEL_ESPACE_ROUTE)
        {
            $session->set('afterLoginRoute',null);
            return $this->redirectToRoute('_lostbook_nouvel_espace');
        }
        else
        {
            return $this->render('lostBookBundle:Default:index.html.twig',
                    array('pagination'=>$pagination,
                          'form'=>$form->createView()));
        }       
        
        
    }
    
    
    
    /**
     * C'est le controleur qui est appellé pour générer et 
     * afficher le formulaire de création d'une nouvelle 
     * annonce
     * @return type
     */
    public function nouvelleAnnonceAction()
    {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');   
        
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
           if($user!='anon.')
           {             
             $annonce->setUtilisateur($user);  
           }
           else
           {
               
               $annonce->setUtilisateur(NULL);
           }
           
           $annonce->setPerdu(true);
           $annonce->setEtat('0');
           $date = new \DateTime('today');
           $annonce->setDateCreation($date);
           $idText = $annonce->getIdEspaceHandler();
           $idTextArray = preg_split("#-#", $idText);
           if(isset($idTextArray[0]))
           {
               $idEspace = preg_replace('/\s+/', '', $idTextArray[0]);
           }
           $espace = $espaceRepository->find($idEspace); 
           $annonce->setEspace($espace);
           $annonce->setNombreVues(0);
           $espace->setNombreAnnonces($espace->getNombreAnnonces() + 1);
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
           return $this->redirect($this->generateUrl('_lostbook_homepage'));
       }
       else
       {
           
            return $this->render('lostBookBundle:Annonces:publierAnnonce.html.twig',array('form'=>$form->createView()));
       }


    }
    
    public function updateAnnonceAction($idAnnonce)
    {
       $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');   
       $annonceRepository = $this->getDoctrine()->getRepository("lostBookBundle:Annonce");
       $mediaAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaAnnonce');
        
        //On récupère la requête
        $request = $this->getRequest();
        
        //On récupère l'annonce
        $annonce = $annonceRepository->find($idAnnonce);
        $medias = $mediaAnnonceRepository->findBy(array('annonce'=>$annonce->getId()));
        $annonce->setMedias($medias);

        //on crée le formulaire en se basant sur l'objet récupéré précédemment
       $form = $this->createForm(new AnnonceType(), $annonce);

       $form->handleRequest($request);

       if($form->isValid())
       {
           
           $session = $request->getSession();
           $user = $this->container->get('security.context')->getToken()->getUser();
           if($user!='anon.')
           {             
             $annonce->setUtilisateur($user);  
           }
           else
           {
               
               $annonce->setUtilisateur(NULL);
           }
           
           $annonce->setPerdu(true);
           $annonce->setEtat('0');
           $date = new \DateTime('today');
           $annonce->setDateCreation($date);
           $idText = $annonce->getIdEspaceHandler();
           $idTextArray = preg_split("#-#", $idText);
           if(isset($idTextArray[0]))
           {
               $idEspace = preg_replace('/\s+/', '', $idTextArray[0]);
           }
           if($annonce->getEspace()->getId() != $idEspace)
           {
                $espacePrecedent = $espaceRepository->find($annonce->getEspace()->getId());
                $espace = $espaceRepository->find($idEspace); 
                $annonce->setEspace($espace);
                $espace->setNombreAnnonces($espace->getNombreAnnonces() + 1);
                $espacePrecedent->setNombreAnnonces($espacePrecedent->getNombreAnnonces() - 1);
           }
           $em = $this->getDoctrine()->getManager();

          
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
           return $this->redirect($this->generateUrl('_lostbook_homepage'));
       }
       else
       {
           
            return $this->render('lostBookBundle:Annonces:majAnnonce.html.twig',
                    array('form'=>$form->createView(),
                          'annonce'=>$annonce));
       }  
    }

    public function detailsAnnonceAction($idAnnonce)
    {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
        $mediaAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaAnnonce');

        $annonce = $annonceRepository->find($idAnnonce);
        $annonce->setNombreVues($annonce->getNombreVues()+1);
        $medias = $mediaAnnonceRepository->findBy(array('annonce'=>$annonce->getId()));
        $annonce->setMedias($medias);
        $em->flush();
        return $this->render('lostBookBundle:Annonces:detailsAnnonce.html.twig',array('annonce'=>$annonce));

    }

}
