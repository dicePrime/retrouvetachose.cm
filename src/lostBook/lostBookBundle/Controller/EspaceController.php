<?php

namespace lostBook\lostBookBundle\Controller;

/**
 * Description of EspaceController
 *
 * @author ndziePatrick
 */
use lostBook\lostBookBundle\Entity\MediaEspace;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lostBook\lostBookBundle\Entity\Espace;
use lostBook\lostBookBundle\Form\Type\EspaceType;
use Symfony\Component\HttpFoundation\Request;
use lostBook\lostBookBundle\Form\Type\RechercheEspacesType;
use lostBook\lostBookBundle\Entity\RechercheEspaces;
use lostBook\lostBookBundle\Commons\Routes;

class EspaceController extends Controller {
    //put your code here

    /**
     * Ce controller affiche la page d'accueil de toutes
     * les pages dédies.
     */
    public function indexAction() {

        $request = $this->getRequest();
        $session = $request->getSession();
        $homeMessage = $session->get(Routes::$HOME_MESSAGE);
        $afficherRecherche = FALSE;
        if ($session->get('rechercheEspaces') != null) {
            $recherche = $session->get('rechercheEspaces');
        } else {
            $recherche = new RechercheEspaces();
        }
        $form = $this->createForm(new RechercheEspacesType(), $recherche);
        $form->handleRequest($request);

        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');


        if ($form->isValid()) {
            $espaces = $espaceRepository->getResultatRecherche($recherche);
            $session->set('rechercheEspaces', $recherche);
            $session->set('resultatRechercheEspaces', $espaces);
            $afficherRecherche = TRUE;
        } else {

            if ($session->get('resultatRechercheEspaces') != null) {

                $espaces = $session->get('resultatRechercheEspaces');
            } else {
                $espaces = $espaceRepository->findAll();
            }
        }



        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $espaces, $request->query->getInt('page', 1)/* page number */, 6/* limit per page */
        );


        return $this->render('lostBookBundle:Espaces:index.html.twig', array('pagination' => $pagination,
                    'message' => $homeMessage,
                    'afficherRecherche'=> $afficherRecherche,
                    'form' => $form->createView()));
    }

    /**
     * Ce controller est chargé de gérer la création d'un
     * nouvel espace.
     */
    public function nouvelEspaceAction() {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');

        //On récupère la requête
        $request = $this->getRequest();

        //On crée un nouvel objet annonce, avec ses champs vides
        $espace = new Espace();

        //on crée le formulaire en se basant sur l'objet annonce crée précedemment
        $form = $this->createForm(new EspaceType(), $espace);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $session = $request->getSession();
            $user = $this->container->get('security.context')->getToken()->getUser();
            $espace->setAdministrateur($user);

            $date = new \DateTime('today');
            $espace->setDateCreation($date);

            $em = $this->getDoctrine()->getManager();

            $em->persist($espace);
            $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
            $manager->getFiles();
            $files = $manager->uploadFiles();

            //à ce niveau, on met à jour l'annonce en définissant son image par défaut
            foreach ($files as $document) {
                $tmp = new MediaEspace();
                $tmp->file = $document;
                $tmp->setEspace($espace);
                $tmp->preUpload();
                $em->persist($tmp);
                $tmp->upload();
            }

            if (isset($files[0])) {
                $espace->setImagePrincipale($files[0]->getFileName());
            }
            $espace->setNombreAnnonces(0);


            $em->flush();
            //Ici on met à jour l'objet annonce en lui définissant une image principale
            return $this->redirect($this->generateUrl('_lostbook_espaces_index'));
        } else {
            return $this->render('lostBookBundle:Espaces:nouvelEspace.html.twig', array('form' => $form->createView()));
        }
    }

    public function detailsEspaceAction(Request $request, $idEspace) {

        $em = $this->getDoctrine()->getManager();
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');

        $espace = $espaceRepository->find($idEspace);
        $espace->setNombreVisites($espace->getNombreVisites() + 1);
        $annonces = $annonceRepository->findBy(array('espace' => $espace->getId()));
        $em->flush();
        $session = $request->getSession();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $annonces, $request->query->getInt('page', 1)/* page number */, 2/* limit per page */
        );

        $securityBag = $session->get("securityBag");


        $code = isset($securityBag['codeProprietaireEspace']) ? $securityBag['codeProprietaireEspace'] : 0;
        $message = isset($securityBag['messageProprietaireEspace']) ? $securityBag['messageProprietaireEspace'] : NULL;

        $securityBag['codeProprietaireEspace'] = 0;
        $securityBag['messageProprietaireEspace'] = NULL;

        $session->set("securityBag", $securityBag);

        return $this->render('lostBookBundle:Espaces:detailsEspace.html.twig', array('espace' => $espace,
                    'code' => $code,
                    'message' => $message,
                    'pagination' => $pagination));
    }

    public function updateEspaceAction($idEspace) {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');
        $mediaEspaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaEspace');

        //On récupère la requête
        $request = $this->getRequest();

        //On récupère l'annonce
        $espace = $espaceRepository->find($idEspace);
        $medias = $mediaEspaceRepository->findBy(array('espace' => $espace->getId()));
        $espace->setMedias($medias);

        //on crée le formulaire en se basant sur l'objet récupéré précédemment
        $form = $this->createForm(new EspaceType(), $espace);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $manager = $this->get('oneup_uploader.orphanage_manager')->get('gallery');
            $manager->getFiles();
            $files = $manager->uploadFiles();

            //à ce niveau, on met à jour l'annonce en définissant son image par défaut
            foreach ($files as $document) {
                $tmp = new MediaEspace();
                $tmp->file = $document;
                $tmp->setEspace($espace);
                $tmp->preUpload();
                $em->persist($tmp);
                $tmp->upload();
            }
            if (isset($files[0])) {
                $espace->setImagePrincipale($files[0]->getFileName());
            }
            else
            {
                $espace->setimagePrincipale(NULL);
            }

            $em->flush();

            //Ici on met à jour l'objet annonce en lui définissant une image principale
            return $this->redirect($this->generateUrl('_lostbook_homepage'));
        } else {

            return $this->render('lostBookBundle:Espaces:majEspace.html.twig', array('form' => $form->createView(),
                        'espace' => $espace));
        }
    }

    public function deleteEspaceAction($idEspace) {
        $em = $this->getDoctrine()->getManager();
        $espaceRepository = $this->getDoctrine()->getRepository("lostBookBundle:Espace");
        //On récupère la requête
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->set(Routes::$HOME_MESSAGE, "general.espace_supprime");

        //On récupère l'annonce
        $espace = $espaceRepository->find($idEspace);
        $espace->setEtat("1");
        $annonces = $espace->getAnnonces();

        if (NULL != $annonces) {

            foreach ($annonces as $annonce) {
                $annonce->setEspace(NULL);
            }
        }
        $em->flush();
        return $this->redirectToRoute(Routes::$ESPACES_INDEX);
    }

}
