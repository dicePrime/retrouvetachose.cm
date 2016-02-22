<?php

namespace lostBook\lostBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use lostBook\lostBookBundle\Entity\Media;

/**
 * MediaEspace
 *
 * @ORM\Table(name="media_espace")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\MediaEspaceRepository")
 */
class MediaEspace extends Media
{
   /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Espace", inversedBy="medias")
     * @ORM\JoinColumn(name="espace_id", referencedColumnName="id")
     */
    private $espace;

    /**
     * @Override
     */
    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'onaffiche
        // le document/image dans la vue.
        return 'uploads/documents/espaces/';
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
     * Set espace
     *
     * @param \lostBook\lostBookBundle\Entity\Espace $espace
     * @return MediaEspace
     */
    public function setEspace(\lostBook\lostBookBundle\Entity\Espace $espace = null)
    {
        $this->espace = $espace;

        return $this;
    }

    /**
     * Get espace
     *
     * @return \lostBook\lostBookBundle\Entity\Espace 
     */
    public function getEspace()
    {
        return $this->espace;
    }
}
