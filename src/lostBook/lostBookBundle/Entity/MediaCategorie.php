<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of MediaCategorie
 *
 * @author ndziePatrick
 */
use Doctrine\ORM\Mapping as ORM;

use \Doctrine\Common\Collections\ArrayCollection;
use lostBook\lostBookUserBundle\Entity\Utilisateur;
/**
 * MediaCategorie
 *
 * @ORM\Table(name="media_categorie")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\MediaCategorieRepository")
 */

class MediaCategorie {
    //put your code here
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="medias")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     */
    private $categorie;

    /**
     * @Override
     */
    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'onaffiche
        // le document/image dans la vue.
        return 'uploads/documents/categories/';
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
     * Set categorie
     *
     * @param \lostBook\lostBookBundle\Entity\Categorie $categorie
     * @return MediaCategorie
     */
    public function setCategorie(\lostBook\lostBookBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this->categorie;
    }

    /**
     * Get categorie
     *
     * @return \lostBook\lostBookBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
