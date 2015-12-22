<?php

namespace rTC\rTCUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaUtilisateur
 *
 * @ORM\Table(name="media_utilisateur")
 * @ORM\Entity(repositoryClass="rTC\rTCUserBundle\Repository\MediaUtilisateurRepository")
 */
class MediaUtilisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="chemin", type="string", length=255)
     */
    private $chemin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="date_creation", type="string", length=255)
     */
    private $dateCreation;


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
     * Set chemin
     *
     * @param string $chemin
     * @return MediaUtilisateur
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string 
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MediaUtilisateur
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreation
     *
     * @param string $dateCreation
     * @return MediaUtilisateur
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return string 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
}
