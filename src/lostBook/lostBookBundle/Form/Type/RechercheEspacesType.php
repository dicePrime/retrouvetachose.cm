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

class RechercheEspacesType extends AbstractType {
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("debut", "text",array('required'=>false));
        $builder->add("fin", "text",array('required'=>false));
        $builder->add("ville", "entity", array('class' =>'lostBook\lostBookBundle\Entity\Ville','required'=>false
                                        ,'placeholder'=>'ALL'
                                        ,'empty_data'=> null));      
        $builder->add("nom","text",array('required'=>false));
        
   }
    
    public function getName() {
        return 'rechercheAnnonces';
    }
    
}
