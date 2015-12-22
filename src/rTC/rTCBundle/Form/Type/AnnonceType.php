<?php

/**
 * Description of AnnonceType
 * AnnonceType est la classe formulaire 
 * associée à la classe Annonce
 *
 * @author ndziePatrick
 */

namespace rTC\rTCBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use rTC\rTCBundle\Form\Type\DocumentType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AnnonceType extends AbstractType
{
    //put your code here
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("dateDebut","date",array('widget'=>'single_text'));
        $builder->add("dateFin","date",array('widget'=>'single_text'));
        $builder->add("region","choice");
        $builder->add("ville","choice");
        $builder->add("titre","text");
        $builder->add("commentaire","textarea");
        $builder->add("motsCles","textarea");
        $builder->add("categorie","choice");

        
        //$builder->add('document','file',array('multiple'=>true,'data_class'=>'rTC\rTCBundle\Entity\Document'));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'rTC\rTCBundle\Entity\Annonce',
        ));
    }
    
    public function getName() 
    {
        return 'annonce';
    }
    
}
