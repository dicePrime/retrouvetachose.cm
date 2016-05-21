<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Entity;

/**
 * Description of Commetaire
 *
 * @author ndziePatrick
 */


use Doctrine\ORM\Mapping as ORM;

class Commentaire {
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
     * @ORM\Column(name="commentaire", type="text")
     */
    protected $commentaire;
    
     /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string",nullable=TRUE)
     */
    protected $nom;
    
     /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=TRUE)
     */
    protected $email;
    
     /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string")
     */
    protected $pseudo;
    
     /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;
    
   
    
    
    function getCommentaire() {
        return $this->commentaire;
    }

    function getNom() {
        return $this->nom;
    }

    function getEmail() {
        return $this->email;
    }

    function getPseudo() {
        return $this->pseudo;
    }

    function getDate() {
        return $this->date;
    }

    function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }



}
