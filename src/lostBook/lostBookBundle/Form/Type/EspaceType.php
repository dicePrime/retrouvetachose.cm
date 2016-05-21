<?php
namespace lostBook\lostBookBundle\Form\Type;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EspaceType
 *
 * @author ndziePatrick
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use lostBook\lostBookBundle\Form\Type\DocumentType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EspaceType extends AbstractType
{
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add("ville","entity",array('class'=>'lostBook\lostBookBundle\Entity\Ville','property'=>'libelle'));
        $builder->add("nom","text");
        $builder->add("description","textarea");
        $builder->add("email","email",array('required' =>false));
        $builder->add("telephone1","text");
        $builder->add("telephone2","text",array('required'=>false));
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'lostBook\lostBookBundle\Entity\Espace',
        ));
    }
    
    public function getName() 
    {
        return 'espace';
    }    
}
