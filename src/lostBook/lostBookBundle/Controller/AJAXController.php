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
use lostBook\lostBookBundle\Entity\CommentaireAnnonce;
use lostBook\lostBookBundle\Entity\CommentaireEspace;
use lostBook\lostBookBundle\Repository\CommentaireAnnonceRepository;
use lostBook\lostBookBundle\Repository\CommentaireEspaceRepository;

class AJAXController extends Controller {

    //put your code here

    public function autoCompleteEspaceAction() {
        
    }

    public function getEspacesForVilleAction($idVille) {
        $espaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Espace');
        $espaces = $espaceRepository->findByVille($idVille);
        $response = new JsonResponse();
        return $response->setData($espaces);
    }

    public function nouveauCommentaireAnnonceAction() {

        $commentaireAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:CommentaireAnnonce');
        $request = $this->getRequest();
        $session = $request->getSession();

        try {
            if ($request->isXmlHttpRequest()) {
                
            } else {
                return new JsonResponse(array('code' => -1, 'message' => 'The file specified was not found'));
            }
        } catch (\Exception $ex) {
            CommonTasks::writeFile('exceptions/controllersExceptions/nouvelleExtractionActionException.txt', $ex->getTraceAsString(), 'w+');
            return new JsonResponse(array('code' => -1, 'message' => 'Programmation error'));
        }
    }

}
