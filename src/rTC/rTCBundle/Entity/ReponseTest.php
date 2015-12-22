<?php

namespace rTC\rTCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReponseTest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rTC\rTCBundle\Repository\ReponseTestRepository")
 */
class ReponseTest
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
     * @ORM\Column(name="is_reponse", type="boolean")
     */
    private $isReponse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="TestProprietaire", inversedBy="reponses")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;


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
     * Set isReponse
     *
     * @param boolean $isReponse
     * @return ReponseTest
     */
    public function setIsReponse($isReponse)
    {
        $this->isReponse = $isReponse;

        return $this;
    }

    /**
     * Get isReponse
     *
     * @return boolean 
     */
    public function getIsReponse()
    {
        return $this->isReponse;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ReponseTest
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set question
     *
     * @param \rTC\rTCBundle\Entity\TestProprietaire $question
     * @return ReponseTest
     */
    public function setQuestion(\rTC\rTCBundle\Entity\TestProprietaire $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \rTC\rTCBundle\Entity\TestProprietaire 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
