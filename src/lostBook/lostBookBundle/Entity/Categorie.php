<?php

namespace lostBook\lostBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * Ce champ stocke les medias associés à une catégorie, plus principalement
     * l'image associée à une catégorie
     * @ORM\OneToMany(targetEntity="MediaCategorie", mappedBy="categorie")
     */
    protected $medias;
    
     /**
     * Cette variable stocke le nom de l'image principale
     * on connait le chemin dans le quel on va chercher l'image, en fonction
     * de l'identifiant de celle-ci
     * @var
     * @ORM\Column(name="image_principale",type="string",nullable=TRUE)
     */
    protected $imagePrincipale;
    
    
    /**
     *
     * @var type
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="categorie")
     */
    private $annonces;
    
    
    /**
     * @var 
     */

    public function __construct()
    {
        $this->medias = new ArrayCollection();
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
     * @return Categorie
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
     * @return Categorie
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
     * Add annonces
     *
     * @param \lostBook\lostBookBundle\Entity\Annonce $annonces
     * @return Categorie
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

    /**
     * Set imagePrincipale
     *
     * @param string $imagePrincipale
     * @return Categorie
     */
    public function setImagePrincipale($imagePrincipale)
    {
        $this->imagePrincipale = $imagePrincipale;

        return $this;
    }

    /**
     * Get imagePrincipale
     *
     * @return string 
     */
    public function getImagePrincipale()
    {
        return $this->imagePrincipale;
    }

    /**
     * Add medias
     *
     * @param \lostBook\lostBookBundle\Entity\MediaCategorie $medias
     * @return Categorie
     */
    public function addMedia(\lostBook\lostBookBundle\Entity\MediaCategorie $medias)
    {
        $this->medias[] = $medias;

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \lostBook\lostBookBundle\Entity\MediaCategorie $medias
     */
    public function removeMedia(\lostBook\lostBookBundle\Entity\MediaCategorie $medias)
    {
        $this->medias->removeElement($medias);
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedias()
    {
        return $this->medias;
    }
}
