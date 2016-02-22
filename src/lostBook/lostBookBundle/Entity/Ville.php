<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of Ville
 *
 * @author ndziePatrick
 */

use Doctrine\ORM\Mapping as ORM;

use \Doctrine\Common\Collections\ArrayCollection;
use lostBook\lostBookUserBundle\Entity\Utilisateur;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\VilleRepository")
 * 
 */

class Ville {
    //put your code here
    
     /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string")
     */
    private $libelle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="libelle_etendu", type="string")
     */
    private $libelleEtendu;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string")
     */
    private $region;
    
    /**
     * @ORM\OneToMany(targetEntity="Espace", mappedBy="ville")
     */
    private $espaces;
    
    /**
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="ville")
     */
    private $annonces;
    
     public function __construct() 
    {
        $this->espaces = new ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     * @return Ville
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set libelleEtendu
     *
     * @param string $libelleEtendu
     * @return Ville
     */
    public function setLibelleEtendu($libelleEtendu)
    {
        $this->libelleEtendu = $libelleEtendu;

        return $this;
    }

    /**
     * Get libelleEtendu
     *
     * @return string 
     */
    public function getLibelleEtendu()
    {
        return $this->libelleEtendu;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Ville
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add espaces
     *
     * @param \lostBook\lostBookBundle\Entity\Espace $espaces
     * @return Ville
     */
    public function addEspace(\lostBook\lostBookBundle\Entity\Espace $espaces)
    {
        $this->espaces[] = $espaces;

        return $this;
    }

    /**
     * Remove espaces
     *
     * @param \lostBook\lostBookBundle\Entity\Espace $espaces
     */
    public function removeEspace(\lostBook\lostBookBundle\Entity\Espace $espaces)
    {
        $this->espaces->removeElement($espaces);
    }

    /**
     * Get espaces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEspaces()
    {
        return $this->espaces;
    }
    
    public function __toString() {
        return $this->getLibelle();
    }

    /**
     * Add annonces
     *
     * @param \lostBook\lostBookBundle\Entity\Annonce $annonces
     * @return Ville
     */
    public function addAnnonce(\lostBook\lostBookBundle\Entity\Annonce $annonces)
    {
        $this->annonces[] = $annonces;

        return $this;
    }

    /**
     * Remove annonces
     *
     * @param \lostBook\lostBookBundle\Entity\Annonce $annonces
     */
    public function removeAnnonce(\lostBook\lostBookBundle\Entity\Annonce $annonces)
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
