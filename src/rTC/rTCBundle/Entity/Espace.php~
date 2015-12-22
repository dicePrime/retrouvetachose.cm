<?php

namespace rTC\rTCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \octrine\Common\Collections\ArrayCollection;

/**
 * Espace
 *
 * @ORM\Table(name="espace")
 * @ORM\Entity(repositoryClass="rTC\rTCBundle\Repository\EspaceRepository")
 */
class Espace
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
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;
        
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="dateCreation", type="string")
     */
    private $dateCreation;
    
    
     /**
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="espace")
     */
    private $annonces;

    
    public function __construct() {
        $this->annonces = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return Espace
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    
    /**
     * Set description
     *
     * @param string $description
     * @return Espace
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
     * @return Espace
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

    /**
     * Add annonces
     *
     * @param \rTC\rTCBundle\Entity\Annonce $annonces
     * @return Espace
     */
    public function addAnnonce(\rTC\rTCBundle\Entity\Annonce $annonces)
    {
        $this->annonces[] = $annonces;

        return $this;
    }

    /**
     * Remove annonces
     *
     * @param \rTC\rTCBundle\Entity\Annonce $annonces
     */
    public function removeAnnonce(\rTC\rTCBundle\Entity\Annonce $annonces)
    {
        $this->annonces->removeElement($annonces);
    }

    /**
     * Get annonces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnnonces()
    {
        return $this->annonces;
    }
}
