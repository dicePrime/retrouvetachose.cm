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
    
    protected $espace;
    
    function getVille() {
        return $this->ville;
    } 
   
    function setVille($ville) {
        $this->ville = $ville;
    }

    function getEspace() {
        return $this->espace;
    }

    function setEspace($espace) {
        $this->espace = $espace;
    }




    
  
}
