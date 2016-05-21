<?php

/**
 * Description of AnnonceType
 * AnnonceType est la classe formulaire 
 * associée à la classe Annonce
 *
 * @author ndziePatrick
 */

namespace lostBook\lostBookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use lostBook\lostBookBundle\Entity\Ville;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class AnnonceType extends AbstractType {

    //put your code here

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add("dateDebut", "text");
        $builder->add("dateFin", "text");
        $builder->add("ville", "entity", array('class' => 'lostBook\lostBookBundle\Entity\Ville',
            'placeholder' => ''));
        $builder->add("titre", "text");
        $builder->add("commentaire", "textarea");
        $builder->add("motsCles", "textarea");
        $builder->add("categorie", "entity", array('class' => 'lostBook\lostBookBundle\Entity\Categorie', 'property' => 'nom'));
        $builder->add("meContacter", "checkbox", array('required' => false));
        $builder->add("avecRecompense", "checkbox", array('required' => false));
        $builder->add("montantRecompense", "number", array('required' => false));
        $builder->add("autreRecompense", "textarea", array('required' => false));
        $builder->add("numeroPiece","text", array('required' => false));
        $builder->add("nomPiece","text",array('required'=> false));
        $builder->add("prenomPiece","text",array('required'=> false));

        $formModifier = function (FormInterface $form, Ville $ville = null) {
            $espaces = null === $ville ? array() : $ville->getEspaces();

            $form->add('espace','entity', array(
                'class' => 'lostBookBundle:Espace',
                'placeholder' => '',
                'required'=> false,
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

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'lostBook\lostBookBundle\Entity\Annonce',
        ));
    }

    public function getName() {
        return 'annonce';
    }

}
