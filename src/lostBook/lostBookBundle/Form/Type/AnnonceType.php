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
use Symfony\Component\Form\FormEvent;

class AnnonceType extends AbstractType {

    //put your code here

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("dateDebut", "text");
        $builder->add("dateFin", "text");
        $builder->add("ville", "entity", array('class' =>'lostBook\lostBookBundle\Entity\Ville'));
        $builder->add("titre", "text");
        $builder->add("couleurObjet","text");
        $builder->add("commentaire", "textarea");
        $builder->add("motsCles", "textarea");
        $builder->add("categorie", "entity", array('class'=>'lostBook\lostBookBundle\Entity\Categorie','property'=>'nom'));
        $builder->add("idEspaceHandler","text",array('attr'=>array('required'=>false)));
        $builder->add("codeCreateur","password",array('attr'=>array('required'=>false)));
        $builder->add("confirmCode","password",array('attr'=>array('required'=>false)));
        $builder->add("email","email");
        $builder->add("telephone1","text",array('attr'=>array('required'=>false)));
        $builder->add("telephone2","text",array('required'=>false));
        $builder->add("meContacter","checkbox",array('attr'=>array('checked'=>'checked'),'required'=>false));
        $builder->add("avecRecompense","checkbox",array('required'=>false));
        $builder->add("montantRecompense","number",array('required'=>false));
        $builder->add("perdu","choice",array('choices'=>array('0'=>'Perte','1'=>'Restitution','required'=>false)));
        $builder->add("autreRecompense","textarea",array('required'=>false));
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
