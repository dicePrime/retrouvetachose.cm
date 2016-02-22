<?php
namespace lostBook\lostBookBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


/**
 * Description of EspaceAdmin
 *
 * @author ndziePatrick
 */
class EspaceAdmin extends Admin {
    //put your code here
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Content')
                ->add('nom','text')
                ->add('description','textarea')
                ->add('dateCreation', 'date', array('widget' => 'single_text'))
                ->end()
                ->with('Meta data')
                ->add('ville','entity',array('class'=>'lostBook\lostBookBundle\Entity\Ville','property'=>'libelle'));                
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nom');
        $datagridMapper->add('description');
        $datagridMapper->add('dateCreation');
        $datagridMapper->add('ville');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nom');
        $listMapper->addIdentifier('description');
        $listMapper->addIdentifier('dateCreation');
        $listMapper->addIdentifier('ville');
    }
    public function toString($object)
    {
        return $object instanceof Espace
            ? $object->getNom()
            : 'Espace'; // shown in the breadcrumb on the create view
    }
}
