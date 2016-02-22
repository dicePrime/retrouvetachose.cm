<?php

namespace lostBook\lostBookBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


/**
 * Description of VilleAdmin
 *
 * @author ndziePatrick
 */
class VilleAdmin extends Admin{
    //put your code here
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('libelle','text');
        $formMapper->add('region','choice',array("choices"=>array('NORD','CENTRE','LITTORAL','OUEST')));
                
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('libelle');
        $datagridMapper->add('region');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('libelle');
        $listMapper->addIdentifier('region');
    }
    
    public function toString($object)
    {
        return $object instanceof Ville
            ? $object->getLibelle()
            : 'Ville'; // shown in the breadcrumb on the create view
    }
}
