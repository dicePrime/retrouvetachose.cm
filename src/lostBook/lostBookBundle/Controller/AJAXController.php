<?php
namespace lostBook\lostBookBundle\Controller;



/**
 * Description of AJAXController
 * 
 * C'est dans ce controlleur que sont gérées toutes 
 * les opérations AJAX de l'application
 * 
 *
 * @author ndziePatrick
 */


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lostBook\lostBookBundle\Entity\Espace;
use lostBook\lostBookBundle\Form\Type\AnnonceType;
use Symfony\Component\HttpFoundation\File;
use lostBook\lostBookBundle\Commons\Routes;
use Symfony\Component\HttpFoundation\JsonResponse;

class AJAXController extends Controller 
{
    //put your code here
    
    public function autoCompleteEspaceAction()
    {
          
    }
    
    public function getEspacesForVilleAction($idVille)
    {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');   
        $espaces = $espaceRepository->findByVille($idVille);        
        $response = new JsonResponse();
        return $response->setData($espaces);
    }
}
