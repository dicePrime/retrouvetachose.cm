<?php

namespace lostBook\lostBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use lostBook\lostBookBundle\Entity\Media;
use Doctrine\Common\Annotations\Annotation;
/**
 * MediaAnnonce
 *
 * @ORM\Table(name="media_annonce")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\MediaAnnonceRepository")
 */
class MediaAnnonce extends Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Annonce", inversedBy="medias")
     * @ORM\JoinColumn(name="annonce_id", referencedColumnName="id")
     */
    private $annonce;

    
    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'onaffiche
        // le document/image dans la vue.
        return 'uploads/documents/annonces/';
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
     * Set annonce
     *
     * @param \lostBook\lostBookBundle\Entity\Annonce $annonce
     * @return MediaAnnonce
     */
    public function setAnnonce(\lostBook\lostBookBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \lostBook\lostBookBundle\Entity\Annonce 
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
}
