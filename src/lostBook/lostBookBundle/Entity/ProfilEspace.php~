<?php

namespace lostBook\lostBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilEspace
 *
 * @ORM\Table(name="profil_espace")
 * @ORM\Entity(repositoryClass="lostBook\lostBookBundle\Repository\ProfilEspaceRepository")
 */
class ProfilEspace
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_creator", type="boolean")
     */
    private $isCreator;


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
     * Set isAdmin
     *
     * @param boolean $isAdmin
     * @return ProfilEspace
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set isCreator
     *
     * @param boolean $isCreator
     * @return ProfilEspace
     */
    public function setIsCreator($isCreator)
    {
        $this->isCreator = $isCreator;

        return $this;
    }

    /**
     * Get isCreator
     *
     * @return boolean 
     */
    public function getIsCreator()
    {
        return $this->isCreator;
    }
}
