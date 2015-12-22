<?php

namespace rTC\rTCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use rTC\rTCBundle\Entity\Media;
/**
 * MediaAnnonce
 *
 * @ORM\Table(name="media_annonce")
 * @ORM\Entity(repositoryClass="rTC\rTCBundle\Repository\MediaAnnonceRepository")
 */
class MediaAnnonce extends Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Annonce", inversedBy="document")
     * @ORM\JoinColumn(name="annonce_id", referencedColumnName="id")
     */
    private $annonce;

    /**
     * @Override
     */
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
     * @param \rTC\rTCBundle\Entity\Annonce $annonce
     * @return MediaAnnonce
     */
    public function setAnnonce(\rTC\rTCBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \rTC\rTCBundle\Entity\Annonce 
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
}
