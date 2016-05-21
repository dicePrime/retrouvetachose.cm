<?php


namespace lostBook\lostBookBundle\Controller;

use lostBook\lostBookBundle\Entity\MediaAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lostBook\lostBookBundle\Entity\Annonce;
use lostBook\lostBookBundle\Form\Type\AnnonceType;
use Symfony\Component\HttpFoundation\File;
use lostBook\lostBookBundle\Commons\Routes;
use lostBook\lostBookBundle\Entity\RechercheAnnonces;
use lostBook\lostBookBundle\Form\Type\RechercheAnnoncesType;
use lostBook\lostBookUserBundle\Entity\Utilisateur;

/**
 * Description of AutomaticTasksController
 * 
 * Cette classe contient les controlleurs chargés des tâches automatiques
 * Ces tâches sont exécutées à une certaine fréquence
 *
 * @author ndziePatrick
 */
class AutomaticTasksController  {
    //put your code here
    
    /**
     * La tâche rTCMatching s'exécute une fois par
     * jour, sélectionne toutes les annonces qui ont été crée dans la journée
     * pour chacune d'elle vérifie les utilisateurs qui pourraient être concernés
     * et les notifie
     */
    
    public function rTCMatchingAction()
    {
        $annonceRepository = $this->getDoctrine()->getRepository('lostBookBundle:Annonce'); 
        
        $debut = new \DateTime("now");
        
        $debut->setTime(0,0,0);
        
        $debutText = $debut->format('Y-m-d H:i:s');
        
        $fin = new \DateTime("now");
        
        $finText = $fin->format('Y-m-d H:i:s');
        
        $annonces = $annonceRepository->getAnnoncesForAPeriode($debutText, $finText);
        
        foreach($annonces as $annonce)
        {
            $this->rTCMatching($annonce);
        }
    }
    
    
    /**
     * cette fonction prend en paramètre une annonce et retourne tous les utilisateurs
     * pouvant correspondre à celle ci.
     * @param Annonce $annonce
     */
    public function findMatchingUsers(Annonce $annonce) {
        $utilisateursRepository = $this->getDoctrine()->getRepository('lostBookUserBundle:Utilisateur');

        $utilisateurs = $utilisateursRepository->findAll();

        $matchingUsers = array();

        /**
         * Pour chaque utilisateur de l'application si l'un des tests de correspondance nous renvoie vrai
         * on ajoute cet utilisateur à la liste des utilisateurs à informer
         */
        foreach ($utilisateurs as $utilisateur) {
            if ($this->matchingPiece($annonce, $utilisateur)) {
                $matchingUsers[] = $utilisateur;
            } else if ($this->matchingTextElements($annonce, $utilisateur)) {
                $matchingUsers[] = $utilisateur;
            }
        }

        return $matchingUsers;
    }

    public function rTCMatching(Annonce $annonce) {
        $utilisateurs = $this->findMatchingUsers($annonce);
        
        $bccEmails = array();
        
        foreach($utilisateurs as $utilisateur)
        {
            $bccEmails[] = trim($utilisateur->getEmail());
        }

        $this->sendNouvelleAnnonceMail($annonce, $bccEmails);
    }

    /**
     * 
     * @param Annonce $annonce
     * @param Utilisateur $utilisateur
     * @return boolean
     */
    public function matchingPiece(Annonce $annonce, Utilisateur $utilisateur) {


        if (in_array($annonce->getCategorie()->getId(), Routes::$PIECES_IDENTITES)) {
            if ($annonce->getNumeroPiece() == $utilisateur->getNumeroCNI() || $annonce->getNumeroPiece() == $utilisateur->getNumeroPassport()) {
                return TRUE;
            }
            
            if (trim(strtoupper($annonce->getNomPiece())) == trim(strtoupper($utilisateur->getNom())) || trim(strtoupper($annonce->getPrenomPiece())) == trim(strtoupper($utilisateur->getPrenom()))) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function matchingTextElements(Annonce $annonce, Utilisateur $utilisateur) {


        $tags = split(" ", $annonce->getMotsCles());

        foreach ($tags as $nextTag) {
            $condition1 = trim(strtoupper($utilisateur->getNumeroCNI())) == trim(strtoupper($nextTag));
            $condition2 = trim(strtoupper($utilisateur->getNumeroPassport())) == trim(strtoupper($nextTag));
            $condition3 = trim(strtoupper($utilisateur->getNom())) == trim(strtoupper($nextTag));
            $condition4 = trim(strtoupper($utilisateur->getPrenom())) == trim(strtoupper($nextTag));

            if ($condition1 || $condition2 || $condition3 || $condition4) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function sendNouvelleAnnonceMail(Annonce $annonce, $bccEmails) {
        try {

            
            $email = \Swift_Message::newInstance();
            $email->setFrom("npatrickjoel@orange.com", "retrouveTaChose");
            $email->setBcc($bccEmails);
            $email->setSubject("Cette annonce vous concerne peut-être");

            $body = $this->render('lostBookBundle:Emails:newMatchCase.html.twig',array('annonce'=>$annonce));
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

}
