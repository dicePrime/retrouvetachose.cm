<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookUserBundle\Form\Type;

/**
 * Description of ProfileEditType
 *
 * @author ndziePatrick
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileEditType extends AbstractType{
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('telephone1');
        $builder->add('telephone2');
        
       
    }
    
    public function getParent()
    {
        return 'fos_user_profile';
                

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
