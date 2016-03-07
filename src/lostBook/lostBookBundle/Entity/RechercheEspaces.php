<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of RechercheEspaces
 *
 * @author ndziePatrick
 */
class RechercheEspaces {
    //put your code here
    
    protected $ville;
    
    protected $debut;
    
    protected $fin;
    
    protected $nom;
    
    function getVille() {
        return $this->ville;
    }

    function getDebut() {
        return $this->debut;
    }

    function getFin() {
        return $this->fin;
    }

    function getNom() {
        return $this->nom;
    }

    function setVille($ville) {
        $this->ville = $ville;
    }

    function setDebut($debut) {
        $this->debut = $debut;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }


    
  
}
