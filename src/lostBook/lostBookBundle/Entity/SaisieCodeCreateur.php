<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of SaisiCodeCreateur
 *
 * @author ndziePatrick
 */
class SaisieCodeCreateur {
    //put your code here
    
    protected $email;
    
    protected $code;
    
    function getEmail() {
        return $this->email;
    }

    function getCode() {
        return $this->code;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCode($code) {
        $this->code = $code;
    }


}
