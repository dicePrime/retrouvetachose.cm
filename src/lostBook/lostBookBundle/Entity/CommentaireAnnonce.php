<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of Commetaire
 *
 * @author ndziePatrick
 */


use Doctrine\ORM\Mapping as ORM;
use lostBook\lostBookBundle\Entity\Commentaire;
/**
 * Annonce
 *
 * @ORM\Table(name="commentaire_annonce")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\CommentaireAnnonceRepository")
 */
class CommentaireAnnonce extends Commentaire {
  
    
    /**
     * @ORM\ManyToOne(targetEntity="lostBook\lostBookUserBundle\Entity\Utilisateur", inversedBy="commentairesAnnonce")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $utilisateur;
    
    /**
     * @ORM\ManyToOne(targetEntity="lostBook\lostBookBundle\Entity\Annonce", inversedBy="commentaires")
     * @ORM\JoinColumn(name="annonce_id", referencedColumnName="id")
     */
    protected $annonce;
        
    function getUtilisateur() {
        return $this->utilisateur;
    }

    function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }



    /**
     * Set annonce
     *
     * @param \lostBook\lostBookBundle\Entity\Annonce $annonce
     * @return CommentaireAnnonce
     */
    public function setAnnonce(\lostBook\lostBookBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \lostBook\lostBookBundle\Entity\Annonce 
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
}
