<?php

namespace lostBook\lostBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;
use lostBook\lostBookUserBundle\Entity\Utilisateur;

/**
 * Espace
 *
 * @ORM\Table(name="espace")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\EspaceRepository")
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
     * @ORM\Column(name="date_creation", type="date")
     */
    private $dateCreation;
    
    
     /**
     * Cette variable stocke le nom de l'image principale
     * on connait le chemin dans le quel on va chercher l'image, en fonction
     * de l'identifiant de celle-ci
     * @var
     * @ORM\Column(name="image_principale",type="string",nullable=  TRUE)
     */
    protected $imagePrincipale;
                
    /**
     *@ORM\ManyToOne(targetEntity="Ville",inversedBy="espaces")
     *@ORM\JoinColumn(name="ville_id",referencedColumnName="id")
     */
    protected $ville;
    
    
     /**
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="espace")
     */
    private $annonces;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="lostBook\lostBookUserBundle\Entity\Utilisateur", inversedBy="espaces")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $administrateur;
       
     
    /**
     * Ce champ stocke les medias associés à un espace dédié
     * @ORM\OneToMany(targetEntity="MediaEspace", mappedBy="espace")
     */
    protected $medias;
    
      /**
     * ce champ represente le nombre d'annonces liés à l'espace
     * dédié concerné, ce champ doit être mis à jour automatiquement
     * par un trigger chaque fois que l'on crée une nouvelle 
     * annonce, le but étant de limiter à une requête chaque action de
     * l'utilisateur
     * 
     * @var integer
     * @ORM\Column(name="nombre_annonces",type="integer",nullable=TRUE) 
     */
    protected $nombreAnnonces = 0;
    
    
    /**
     *
     * @var string
     * @ORM\Column(name="email",type="string",nullable=TRUE)
     */
    protected $email;
    
    
    /**
     *
     * @var string
     * @ORM\Column(name="telephone1",type="string",nullable=TRUE)
     */
    protected $telephone1;
    
    
    /**
     *
     * @var string
     * @ORM\Column(name="telephone2",type="string",nullable=TRUE)
     */
    protected $telephone2;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="nombre_visites",type="integer",nullable=TRUE,options={"default:0"})
     */
    protected $nombreVisites;
    
    
    /**
     * @var string
     * 0 = valide
     * 1 = suprimée
     * @ORM\Column(name="etat", type="string")
     */
    protected $etat = 0;
    
    
    /**
     * @ORM\OneToMany(targetEntity="lostBook\lostBookBundle\Entity\CommentaireEspace", mappedBy="espace")
     */
    protected $commentaires;
    
    

    
    public function __construct() {
        $this->medias = new ArrayCollection();
        $this->annonces = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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
     * @param \lostBook\lostBookBundle\Entity\Annonce $annonces
     * @return Espace
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
    
    public function __toString() {
        return $this->getNom();
    }

    /**
     * Set imagePrincipale
     *
     * @param string $imagePrincipale
     * @return Espace
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
     * Set nombreAnnonces
     *
     * @param integer $nombreAnnonces
     * @return Espace
     */
    public function setNombreAnnonces($nombreAnnonces)
    {
        $this->nombreAnnonces = $nombreAnnonces;

        return $this;
    }

    /**
     * Get nombreAnnonces
     *
     * @return integer 
     */
    public function getNombreAnnonces()
    {
        return $this->nombreAnnonces;
    }

    /**
     * Set ville
     *
     * @param \lostBook\lostBookBundle\Entity\Ville $ville
     * @return Espace
     */
    public function setVille(\lostBook\lostBookBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \lostBook\lostBookBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add medias
     *
     * @param \lostBook\lostBookBundle\Entity\MediaEspace $medias
     * @return Espace
     */
    public function addMedia(\lostBook\lostBookBundle\Entity\MediaEspace $medias)
    {
        $this->medias[] = $medias;

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \lostBook\lostBookBundle\Entity\MediaEspace $medias
     */
    public function removeMedia(\lostBook\lostBookBundle\Entity\MediaEspace $medias)
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
    /**
     * Set telephone1
     *
     * @param string $telephone1
     * @return Espace
     */
    public function setTelephone1($telephone1)
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    /**
     * Get telephone1
     *
     * @return string 
     */
    public function getTelephone1()
    {
        return $this->telephone1;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     * @return Espace
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string 
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set administrateur
     *
     * @param \lostBook\lostBookUserBundle\Entity\Utilisateur $administrateur
     * @return Espace
     */
    public function setAdministrateur(\lostBook\lostBookUserBundle\Entity\Utilisateur $administrateur = null)
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    /**
     * Get administrateur
     *
     * @return \lostBook\lostBookUserBundle\Entity\Utilisateur 
     */
    public function getAdministrateur()
    {
        return $this->administrateur;
    }

    /**
     * Set nombreVisites
     *
     * @param integer $nombreVisites
     * @return Espace
     */
    public function setNombreVisites($nombreVisites)
    {
        $this->nombreVisites = $nombreVisites;

        return $this;
    }

    /**
     * Get nombreVisites
     *
     * @return integer 
     */
    public function getNombreVisites()
    {
        return $this->nombreVisites;
    }

    /**
     * Add commentaires
     *
     * @param \lostBook\lostBookBundle\Entity\CommentaireEspace $commentaires
     * @return Espace
     */
    public function addCommentaire(\lostBook\lostBookBundle\Entity\CommentaireEspace $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \lostBook\lostBookBundle\Entity\CommentaireEspace $commentaires
     */
    public function removeCommentaire(\lostBook\lostBookBundle\Entity\CommentaireEspace $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function setAnnonces($annonces) {
        $this->annonces = $annonces;
    }

    function setMedias($medias) {
        $this->medias = $medias;
    }

    function setCommentaires($commentaires) {
        $this->commentaires = $commentaires;
    }
    
    function getEtat() {
        return $this->etat;
    }

    function setEtat($etat) {
        $this->etat = $etat;
    }


}
