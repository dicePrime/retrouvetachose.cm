<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocumentType
 *
 * @author ndziePatrick
 */

namespace rTC\rTCBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType {

    //put your code here

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('file', 'file');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'rTC\rTCBundle\Entity\Document',
        ));
    }

    public function getName() {
        return 'document';
    }

}
