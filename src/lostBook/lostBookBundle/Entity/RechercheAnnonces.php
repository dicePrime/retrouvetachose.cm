<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of RechercheAnnonces
 *
 * @author ndziePatrick
 */
class RechercheAnnonces {
    //put your code here
    
    /**
     *
     * @var string
     */
    protected $debut;
    
    /**
     * 
     * @var string
     */
    protected $fin;
    
    
    /**
     *
     * @var boolean
     */
    protected $nature;
    
    /**
     *
     * @var integer
     */
    
    protected $categorie;
    
    /**
     *
     * @var integer
     */
    
    protected $espace;
    
    /**
     *
     * @var boolean
     */
    
    /**
     *
     * @var integer
     */
    protected $ville;
        
    protected $avecRecompense;
    
    function getDebut() {
        return $this->debut;
    }

    function getFin() {
        return $this->fin;
    }

    function getNature() {
        return $this->nature;
    }

    function getCategorie() {
        return $this->categorie;
    }

    function getEspace() {
        return $this->espace;
    }

    function getAvecRecompense() {
        return $this->avecRecompense;
    }

    function setDebut($debut) {
        $this->debut = $debut;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

    function setNature($nature) {
        $this->nature = $nature;
    }

    function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    function setEspace($espace) {
        $this->espace = $espace;
    }

    function setAvecRecompense($avecRecompense) {
        $this->avecRecompense = $avecRecompense;
    }
    
    function getVille() {
        return $this->ville;
    }

    function setVille($ville) {
        $this->ville = $ville;
    }
    
   




}
