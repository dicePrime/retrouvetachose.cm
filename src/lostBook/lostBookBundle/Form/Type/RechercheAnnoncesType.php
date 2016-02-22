<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Form\Type;

/**
 * Description of RechercheAnnoncesType
 *
 * @author ndziePatrick
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RechercheAnnoncesType extends AbstractType {
    //put your code here
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("debut", "text",array('required'=>false));
        $builder->add("fin", "text",array('required'=>false));
        $builder->add("ville", "entity", array('class' =>'lostBook\lostBookBundle\Entity\Ville','required'=>false
                                        ,'placeholder'=>'ALL'
                                        ,'empty_data'=> null));
        $builder->add("categorie", "entity", array('class'=>'lostBook\lostBookBundle\Entity\Categorie',
                                 'property'=>'nom','required'=>false,
                                 'placeholder'=>'ALL',
                                 'empty_data'=>null));
        $builder->add("espace","text",array('required'=>false));
        $builder->add("avecRecompense","checkbox",array('required'=>false));
        $builder->add("nature","choice",array('choices'=>array('0'=>'Perte','1'=>'Restitution'),
                                'required'=>false,
                                'placeholder'=>'ALL',
                                'empty_data'=> null
                                    ));
   }
    
    public function getName() {
        return 'rechercheAnnonces';
    }
}
