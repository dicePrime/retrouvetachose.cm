<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Form\Type;

/**
 * Description of SaisiCodeCreateurType
 *
 * @author ndziePatrick
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SaisieCodeCreateurType extends AbstractType {
    //put your code here
    
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        $builder->add("email","email",array('required'=>false));
        $builder->add("code","password");
               
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'lostBook\lostBookBundle\Entity\SaisieCodeCreateur',
        ));
    }
    
    public function getName() 
    {
        return 'saisiCodeCreateur';
    }  
}
