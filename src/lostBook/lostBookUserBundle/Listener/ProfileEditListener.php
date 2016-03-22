<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookUserBundle\Listener;

/**
 * Description of ProfileEditListener
 *
 * @author ndziePatrick
 */
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use lostBook\lostBookUserBundle\Entity\MediaUtilisateur;

class ProfileEditListener implements EventSubscriberInterface {

    //put your code here
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents() {

        return array(
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onProfileEditSuccess',
        );
    }

    public function onProfileEditSuccess(FormEvent $event) {

        
        $request = $event->getRequest();
        $utilisateur = $event->getForm()->getData();

        $em = $this->container->get('doctrine')->getManager();



        $manager = $this->container->get('oneup_uploader.orphanage_manager')->get('gallery');
        //$files = $manager->getFiles();
        $files = $manager->uploadFiles();

        //à ce niveau, on met à jour l'annonce en définissant son image par défaut
        foreach ($files as $uploadedFile) {

            $mediaUtilisateur = new MediaUtilisateur();
            $mediaUtilisateur->file = $uploadedFile;

            //die('ici');
            $mediaUtilisateur->setUtilisateur($utilisateur);
            $mediaUtilisateur->preUpload();
            $em->persist($mediaUtilisateur);
            $mediaUtilisateur->upload();
        }

        if (isset($files[0])) {
            $utilisateur->setPhoto($files[0]->getFileName());
        }

        $em->flush();
    }

}
