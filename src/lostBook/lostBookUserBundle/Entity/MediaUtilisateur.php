<?php

namespace lostBook\lostBookUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use lostBook\lostBookBundle\Entity\Media;
use Doctrine\Common\Annotations\Annotation;

/**
 * MediaUtilisateur
 *
 * @ORM\Table(name="media_utilisateur")
 * @ORM\Entity(repositoryClass="lostBook\lostBookUserBundle\Repository\MediaUtilisateurRepository")
 */
class MediaUtilisateur extends Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="media")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $utilisateur;

    
    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'onaffiche
        // le document/image dans la vue.
        return 'uploads/documents/utilisateurs/';
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set utilisateur
     *
     * @param \lostBook\lostBookUserBundle\Entity\Utilisateur $utilisateur
     * @return MediaUtilisateur
     */
    public function setUtilisateur(\lostBook\lostBookUserBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \lostBook\lostBookUserBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
