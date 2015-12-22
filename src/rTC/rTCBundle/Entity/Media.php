<?php

namespace rTC\rTCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Document
 *
 * @author ndziePatrick
 */
class Media {




    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;


    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir() {
// le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
// on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'onaffiche
// le document/image dans la vue.
       // return 'uploads/documents/annonces/';
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Document
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }





    public function preUpload()
    {
        if (null !== $this->file->getPathName())
        {
// faites ce que vous voulez pour générer un nom unique
            $this->path = $this->file->getFileName() ;
        }
    }



    public function upload()
    {
        if (null === $this->file) {
            return;
        }


        try {
            $this->file->move($this->getUploadRootDir(),$this->file->getPathName());
            // avez stocké le fichier
           // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
            $this->file = null;
        }
        catch(\Exception $ex)
        {
            $monfichier = fopen('exception.txt','w+');
            fputs($monfichier,print_r($ex->getMessage(),true));
            fclose($monfichier);
        }
    }


    public function removeUpload() {
        if ($this->file == $this->getAbsolutePath()) {
            unlink($this->file);
        }
    }


}
