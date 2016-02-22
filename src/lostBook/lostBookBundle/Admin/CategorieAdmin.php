<?php
namespace lostBook\lostBookBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;



/**
 * Description of CategorieAdmin
 *
 * @author ndziePatrick
 */
class CategorieAdmin extends Admin{
    //put your code here
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nom','text');
        $formMapper->add('description','textarea');
                
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nom');
        $datagridMapper->add('description');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nom');
        $listMapper->addIdentifier('description');
    }
    
    public function toString($object)
    {
        return $object instanceof Categorie
            ? $object->getNom()
            : 'Categorie'; // shown in the breadcrumb on the create view
    }
}
