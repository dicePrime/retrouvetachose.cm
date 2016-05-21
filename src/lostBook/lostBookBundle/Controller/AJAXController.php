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
use lostBook\lostBookBundle\Entity\Annonce;
use lostBook\lostBookBundle\Form\Type\AnnonceType;
use Symfony\Component\HttpFoundation\File;
use lostBook\lostBookBundle\Commons\Routes;
use Symfony\Component\HttpFoundation\JsonResponse;
use lostBook\lostBookBundle\Entity\CommentaireAnnonce;
use lostBook\lostBookBundle\Entity\CommentaireEspace;
use lostBook\lostBookBundle\Commons\CommonsTasks;
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
    
    public function contacterAnnonceurAction()
    {
        //$utilisateurRepository = $this->getDoctrine()->getRepository('lostBookUserBundle:Utilisateur');
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        
        try {
            if ($request->isXmlHttpRequest()) 
            {
                $idAnnonce = $request->get('idAnnonce');                
                $annonce = $annonceRepository->find($idAnnonce);
                $message = $request->get('message');     
                CommonsTasks::writeFile('commentaires.txt',$message, 'w+');
                $this->sendContactEmail($annonce, $message);
                
                return new JsonResponse(array('code' => 0, 'message' => 'Commentaire Enregistré'));
            } else {
                return new JsonResponse(array('code' => -1, 'message' => 'Le ocmmentaire n\'a pas pu etre enregistré'));
            }
        } 
        catch (\Exception $ex)
        {
            CommonsTasks::writeFile('commentaire.txt', $ex->getMessage().$idAnnonce, 'w+');
            return new JsonResponse(array('code' => -1, 'message' => 'Programmation error'));
        }
    }
    
    
     public function sendContactEmail(Annonce $annonce, $message) {
        try {            
            $email = \Swift_Message::newInstance();
            $email->setFrom("npatrickjoel@orange.com", "retrouveTaChose");
            $email->setBcc($annonce->getUtilisateur()->getEmail());
            $email->setSubject("Un utilisateur vous a contacté");

            $body = $this->render('lostBookBundle:Emails:nouveauContact.html.twig',array('annonce'=>$annonce, 'message'=>$message));
            $email->setBody($body, 'text/html');


            $this->get('mailer')->send($email);
            //$mailer->send($email);
            return true;
        } catch (\Exception $ex) {
            $file = fopen("text.txt","w+");
            
            fputs($file, $ex->getMessage());
            
            fclose($file);
            
            return false;
        }
    }

    public function nouveauCommentaireAnnonceAction() {

        $commentaireAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:CommentaireAnnonce');
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce');
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        try {
            if ($request->isXmlHttpRequest()) {
                $idAnnonce = $request->get('idAnnonce');
                $annonce = $annonceRepository->find($idAnnonce);

                $commentaireAnnonce = new CommentaireAnnonce();

                $commentaireAnnonce->setAnnonce($annonce);
                $commentaireAnnonce->setCommentaire($request->get('commentaire'));
                $commentaireAnnonce->
                        setPseudo($this->container->get('security.context')
                                ->getToken()->getUser()->getUserName());
                $date = new \DateTime('now');
                $commentaireAnnonce->setDate($date);
                $em->persist($commentaireAnnonce);
                $em->flush();
                return new JsonResponse(array('code' => 0, 'message' => 'Commentaire Enregistré'));
            } else {
                return new JsonResponse(array('code' => -1, 'message' => 'Le ocmmentaire n\'a pas pu etre enregistré'));
            }
        } catch (\Exception $ex) {
            CommonsTasks::writeFile('commentaire.txt', $ex->getMessage(), 'w+');
            return new JsonResponse(array('code' => -1, 'message' => 'Programmation error'));
        }
    }
    
    public function deleteImageAnnonceAction($idAnnonce,$idMedia) {

        $mediaAnnonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaAnnonce');
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        try {
            if ($request->isXmlHttpRequest()) {
               
                
                $media = $mediaAnnonceRepository->find($idMedia);
                $em->remove($media);               
                $em->flush();
                return new JsonResponse(array('code' => 0, 'message' => 'Commentaire Enregistré'));
            } else {
                return new JsonResponse(array('code' => -1, 'message' => 'Le ocmmentaire n\'a pas pu etre enregistré'));
            }
        } catch (\Exception $ex) {
            CommonsTasks::writeFile('exceptions/controllersExceptions/nouvelleExtractionActionException.txt', $ex->getMessage(), 'w+');
            return new JsonResponse(array('code' => -1, 'message' => 'Programmation error'));
        }
    }
    public function deleteImageEspaceAction($idEspace,$idMedia) {
        $mediaEspaceRepository = $this->getDoctrine()->getRepository('lostBookBundle:MediaEspace');
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        try {
            if ($request->isXmlHttpRequest()) {
               
                $media = $mediaEspaceRepository->find($idMedia);
                $em->remove($media);               
                $em->flush();
                return new JsonResponse(array('code' => 0, 'message' => 'Commentaire Enregistré'));
            } else {
                return new JsonResponse(array('code' => -1, 'message' => 'Le ocmmentaire n\'a pas pu etre enregistré'));
            }
        } catch (\Exception $ex) {
            CommonsTasks::writeFile('exceptions/controllersExceptions/nouvelleExtractionActionException.txt', $ex->getMessage(), 'w+');
            return new JsonResponse(array('code' => -1, 'message' => 'Programmation error'));
        }
    }
    
    /*public function searchEspacesAction()
    {
        $request = $this->getRequest();
        $q = $request->query->get('q');
        $results = $this->getDoctrine()->getRepository("lostBookBundle:Espace")->findLikeName($q);
        
        return $this->render('lostBookBundle:Annonces:publierAnnonce.html.twig', array('results' => $results));
    }
    
    public function getEspaceAction($id = null)
    {
        $espace = $this->getDoctrine()->getRepository('lostBook:Espace')->find($id);

        return new Response($espace->getNom());
    }*/

}
