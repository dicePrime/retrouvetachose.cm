<?php



namespace lostBook\lostBookBundle\Controller\API;

/**
 * Description of VilleController
 *
 * @author ndziePatrick
 */

use lostBook\lostBookBundle\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class VilleController extends Controller{
    //put your code here
     /**
     * @return array
     * @View()
     */
    
    public function getVillesAction()
    {
        $villeRepository = $this->getDoctrine()->getRepository('lostBookBundle:Ville');
        $villes = $villeRepository->findAll();      
        return array('villes' => $villes);
    }
    
    /**
     * @param id
     * @return Ville
     * @View()
     *      * 
     */
    
    public function getVilleAction($id)
    {
        $villeRepository = $this->getDoctrine()->getRepository('lostBookBundle:Ville');
        $ville = $villeRepository->findOneById($id);      
        return array('ville' => $ville);
    }
}
