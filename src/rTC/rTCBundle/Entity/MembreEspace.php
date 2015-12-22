<?php

namespace rTC\rTCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembreEspace
 *
 * @ORM\Table(name="membre_espace")
 * @ORM\Entity(repositoryClass="rTC\rTCBundle\Repository\MembreEspaceRepository")
 */
class MembreEspace
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
     * @var integer
     *
     * @ORM\Column(name="profil_id", type="integer")
     */
    private $profilId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;


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
     * @return MembreEspace
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
     * Set profilId
     *
     * @param integer $profilId
     * @return MembreEspace
     */
    public function setProfilId($profilId)
    {
        $this->profilId = $profilId;

        return $this;
    }

    /**
     * Get profilId
     *
     * @return integer 
     */
    public function getProfilId()
    {
        return $this->profilId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return MembreEspace
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
