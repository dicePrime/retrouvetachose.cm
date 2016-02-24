<?php

namespace lostBook\lostBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use \Doctrine\Common\Collections\ArrayCollection;
use lostBook\lostBookUserBundle\Entity\Utilisateur;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\AnnonceRepository")
 */
class Annonce {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="perdu",type="boolean",options={"default:0"})
     */ 
    protected $perdu;
    
    
    /**
     *
     * @var boolean
     * @ORM\Column(name="avec_recompense",type="boolean",options={"default:0"})
     */
    protected $avecRecompense;
    
     /**
     *
     * @var type boolean
     * @ORM\Column(name="me_contacter",type="boolean",options={"default:0"})
     */
    protected $meContacter;

    /**
     * @var string
     *
     * @ORM\Column(name="date_debut", type="string")
     */
    protected $dateDebut;
    
    
    //
    protected $idEspaceHandler;
    
    
    /**
     *
     * @var string
     * @ORM\Column(name="code_createur",type="string",nullable=TRUE)
     */
    
    protected $codeCreateur;
    
    protected $confirmCode;
    
       
  

    /**
     * @var string
     *
     * @ORM\Column(name="date_fin", type="string")
     */
    protected $dateFin;

    
     /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="annonces")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")
     */
    protected $ville;
    
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string",options={"defaults:0"})
     */
    protected $etat;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    protected $dateCreation;

    /**
     * Des noms éventuellement, que la personne qui fait l'annonce peut lister
     * ça peut être par exemple des noms qui figurent sur la pièce d'identité
     * @var string
     * @ORM\Column(name="motsCles",type="string",nullable=true)
     */
    protected $motsCles;

    /**
     * Celui qui fait l'annonce a la possibilité de faire un commentaire,
     * celui-ci sera affiché sur les détails de l'annonce.
     * @var string
     * @ORM\Column(name="commentaire",type="string",nullable=TRUE)
     */
    protected $commentaire;
    
    /**
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
     * @var string
     * @ORM\Column(name="email",type="string")
     */
    protected $email;

    /**
     * @var
     * @ORM\Column(name="titre",type="string")
     */
    protected $titre;
    
    /**
     * Cette variable stocke le nom de l'image principale
     * on connait le chemin dans le quel on va chercher l'image, en fonction
     * de l'identifiant de celle-ci
     * @var
     * @ORM\Column(name="image_principale",type="string")
     */
    protected $imagePrincipale;


    /**
     * @ORM\OneToMany(targetEntity="MediaAnnonce", mappedBy="annonce")
     */
    protected $medias;

    /**
     * @ORM\ManyToOne(targetEntity="Espace", inversedBy="annonces")
     * @ORM\JoinColumn(name="espace_id", referencedColumnName="id")
     */
    protected $espace;

    /**
     * @ORM\ManyToOne(targetEntity="lostBook\lostBookUserBundle\Entity\Utilisateur", inversedBy="annonces")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="annonces")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     */
    protected $categorie;  
       
    
    /**
     * Cette variable stocke la description de la couleur de l'objet
     * @var
     * @ORM\Column(name="couleur_objet",type="string")
     */
    protected $couleurObjet;
    
    /**
     *
     * @var type float
     * @ORM\Column(name="montant_recompense",type="float",nullable=true)
     */
    protected $montantRecompense;
    
      
    /**
     *
     * @var string 
     * @ORM\Column(name="autre_recompense",type="string",nullable=true)
     */
    protected $autreRecompense;
    
    
    /**
     *
     * @var integer
     * @ORM\Column(name="nombre_vues",type="integer",nullable=true,options={"default:0"})
     */
    protected $nombreVues;
    
    
    
    

    public function __construct() {
        $this->medias = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set dateDebut
     *
     * @param string $dateDebut
     * @return Annonce
     */
    public function setDateDebut($dateDebut) {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return string 
     */
    public function getDateDebut() {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param string $dateFin
     * @return Annonce
     */
    public function setDateFin($dateFin) {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return string 
     */
    public function getDateFin() {
        return $this->dateFin;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Annonce
     */
    public function setRegion($region) {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Annonce
     */
    public function setVille($ville) {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille() {
        return $this->ville;
    }

    /**
     * Set etat
     *
     * @param string $etat
     * @return Annonce
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Set dateCreation
     *
     * @param string $dateCreation
     * @return Annonce
     */
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return string 
     */
    public function getDateCreation() {
        return $this->dateCreation;
    }

  

    /**
     * Set categorie
     *
     * @param string $categorie
     * @return Annonce
     */
    public function setCategorie($categorie) {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string 
     */
    public function getCategorie() {
        return $this->categorie;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return Annonce
     */
    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire() {
        return $this->commentaire;
    }

    /**
     * Set espace
     * @param \lostBook\lostBookBundle\Entity\Espace $espace
     * @return Annonce
     */
    public function setEspace(\lostBook\lostBookBundle\Entity\Espace $espace = null) {
        $this->espace = $espace;

        return $this;
    }

    /**
     * Get espace
     *
     * @return \lostBook\lostBookBundle\Entity\Espace 
     */
    public function getEspace() {
        return $this->espace;
    }

    /**
     * Set utilisateur
     *
     * @param \lostBook\lostBookBundle\Entity\Utilisateur $utilisateur
     * @return Annonce
     */
    public function setUtilisateur(Utilisateur $utilisateur = null) {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \lostBook\lostBookBundle\Entity\Utilisateur 
     */
    public function getUtilisateur() {
        return $this->utilisateur;
    }

    /**
     * Set perdu
     *
     * @param boolean $perdu
     * @return Annonce
     */
    public function setPerdu($perdu) {
        $this->perdu = $perdu;

        return $this;
    }

    /**
     * Get perdu
     *
     * @return boolean 
     */
    public function getPerdu() {
        return $this->perdu;
    }

    /**
     * Set motsCles
     *
     * @param string $motsCles
     * @return Annonce
     */
    public function setMotsCles($motsCles) {
        $this->motsCles = $motsCles;

        return $this;
    }

    /**
     * Get motsCles
     *
     * @return string 
     */
    public function getMotsCles() {
        return $this->motsCles;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Annonce
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre() {
        return $this->titre;
    }



    /**
     * Add medias
     *
     * @param \lostBook\lostBookBundle\Entity\MediaAnnonce $medias
     * @return Annonce
     */
    public function addMedia(\lostBook\lostBookBundle\Entity\MediaAnnonce $medias)
    {
        $this->medias[] = $medias;

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \lostBook\lostBookBundle\Entity\MediaAnnonce $medias
     */
    public function removeMedia(\lostBook\lostBookBundle\Entity\MediaAnnonce $medias)
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

    public function setMedias($medias)
    {
        $this->medias = $medias;
    }
    
    function getImagePrincipale() {
        return $this->imagePrincipale;
    }

    function setImagePrincipale($imagePrincipale) {
        $this->imagePrincipale = $imagePrincipale;
    }



    /**
     * Set couleurObjet
     *
     * @param string $couleurObjet
     * @return Annonce
     */
    public function setCouleurObjet($couleurObjet)
    {
        $this->couleurObjet = $couleurObjet;

        return $this;
    }

    /**
     * Get couleurObjet
     *
     * @return string 
     */
    public function getCouleurObjet()
    {
        return $this->couleurObjet;
    }

    /**
     * Set codeCreateur
     *
     * @param string $codeCreateur
     * @return Annonce
     */
    public function setCodeCreateur($codeCreateur)
    {
        $this->codeCreateur = $codeCreateur;

        return $this;
    }

    /**
     * Get codeCreateur
     *
     * @return string 
     */
    public function getCodeCreateur()
    {
        return $this->codeCreateur;
    }
    
    function getIdEspaceHandler() {
        return $this->idEspaceHandler;
    }

    function setIdEspaceHandler($idEspaceHandler) {
        $this->idEspaceHandler = $idEspaceHandler;
    }



    /**
     * Set avecRecompense
     *
     * @param boolean $avecRecompense
     * @return Annonce
     */
    public function setAvecRecompense($avecRecompense)
    {
        $this->avecRecompense = $avecRecompense;

        return $this;
    }

    /**
     * Get avecRecompense
     *
     * @return boolean 
     */
    public function getAvecRecompense()
    {
        return $this->avecRecompense;
    }

    /**
     * Set meContacter
     *
     * @param boolean $meContacter
     * @return Annonce
     */
    public function setMeContacter($meContacter)
    {
        $this->meContacter = $meContacter;

        return $this;
    }

    /**
     * Get meContacter
     *
     * @return boolean 
     */
    public function getMeContacter()
    {
        return $this->meContacter;
    }

    /**
     * Set telephone1
     *
     * @param string $telephone1
     * @return Annonce
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
     * @return Annonce
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
     * Set email
     *
     * @param string $email
     * @return Annonce
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set montantRecompense
     *
     * @param float $montantRecompense
     * @return Annonce
     */
    public function setMontantRecompense($montantRecompense)
    {
        $this->montantRecompense = $montantRecompense;

        return $this;
    }

    /**
     * Get montantRecompense
     *
     * @return float 
     */
    public function getMontantRecompense()
    {
        return $this->montantRecompense;
    }

    /**
     * Set autreRecompense
     *
     * @param string $autreRecompense
     * @return Annonce
     */
    public function setAutreRecompense($autreRecompense)
    {
        $this->autreRecompense = $autreRecompense;

        return $this;
    }

    /**
     * Get autreRecompense
     *
     * @return string 
     */
    public function getAutreRecompense()
    {
        return $this->autreRecompense;
    }
    
    function getConfirmCode() {
        return $this->confirmCode;
    }

    function setConfirmCode($confirmCode) {
        $this->confirmCode = $confirmCode;
    }



    /**
     * Set nombreVues
     *
     * @param integer $nombreVues
     * @return Annonce
     */
    public function setNombreVues($nombreVues)
    {
        $this->nombreVues = $nombreVues;

        return $this;
    }

    /**
     * Get nombreVues
     *
     * @return integer 
     */
    public function getNombreVues()
    {
        return $this->nombreVues;
    }
}
