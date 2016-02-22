<?php

namespace lostBook\lostBookBundle\Controller\API;

/**
 * Description of AnnonceController
 *
 * @author ndziePatrick
 */
use lostBook\lostBookBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AnnonceController extends Controller {
    //put your code here
    
    /**
     * @return array
     * @View()
     */
    
    public function getAnnoncesAction()
    {
        $annonceRepository = $this->getDoctrine()->getRepository('rTCBundle:Annonce');
        $annonces = $annonceRepository->getAllAnnonces();      
        return array('annonces' => $annonces);
    }
    
    /**
     * @param id
     * @return Annonce
     * @View()
     *      * 
     */
    
    public function getAnnonceAction($id)
    {
        $annonceRepository = $this->getDoctrine()->getRepository('rTCBundle:Annonce');
        $annonce = $annonceRepository->getAnnonceById($id);         
        return array('annonce'=>$annonce);
    }
    
    
}
