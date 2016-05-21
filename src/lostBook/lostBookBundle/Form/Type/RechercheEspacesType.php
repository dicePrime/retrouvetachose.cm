<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Form\Type;

/**
 * Description of RechercheEspacesType
 *
 * @author ndziePatrick
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use lostBook\lostBookBundle\Entity\Ville;

class RechercheEspacesType extends AbstractType {
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add("ville", "entity", array('class' =>'lostBook\lostBookBundle\Entity\Ville','required'=>false
                                        ,'placeholder'=>'--'
                                        ,'empty_data'=> null));      
        $formModifier = function (FormInterface $form, Ville $ville = null) {
            $espaces = null === $ville ? array() : $ville->getEspaces();

            $form->add('espace','entity', array(
                'class' => 'lostBookBundle:Espace',
                'placeholder' => '--',
                'required'=>false,
                'choices' => $espaces
            ));
        };

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            // this would be your entity, i.e. SportMeetup
            $data = $event->getData();

            $formModifier($event->getForm(), $data->getVille());
        }
        );

        $builder->get('ville')->addEventListener(
                FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
            // It's important here to fetch $event->getForm()->getData(), as
            // $event->getData() will get you the client data (that is, the ID)
            $ville = $event->getForm()->getData();

            // since we've added the listener to the child, we'll have to pass on
            // the parent to the callback functions!
            $formModifier($event->getForm()->getParent(), $ville);
        }
        );
        
   }
    
    public function getName() {
        return 'rechercheEspace';
    }
    
}
