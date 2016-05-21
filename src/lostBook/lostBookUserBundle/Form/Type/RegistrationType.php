<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookUserBundle\Form\Type;

/**
 * Description of RegistrationType
 *
 * @author ndziePatrick
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType {       
    //put your code here
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('telephone1', "text", array('required'=> FALSE ));
        $builder->add('telephone2',"text", array('required'=> FALSE ));
        $builder->add('nom','text', array('required'=> FALSE ));
        $builder->add('prenom','text', array('required'=> FALSE ));
        $builder->add('numeroCNI','text', array('required'=> FALSE ));
        $builder->add('numeroPassport','text',array('required'=> FALSE ));
       
    }
    
    public function getParent()
    {
        return 'fos_user_registration';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
