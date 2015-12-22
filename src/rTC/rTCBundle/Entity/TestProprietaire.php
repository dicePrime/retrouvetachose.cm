<?php

namespace rTC\rTCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \octrine\Common\Collections\ArrayCollection;

/**
 * TestProprietaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rTC\rTCBundle\Repository\TestProprietaireRepository")
 */
class TestProprietaire
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
     * @var string
     *
     * @ORM\Column(name="question", type="text")
     */
    private $question;
    
    /**
     * @var type
     * @ORM\OneToMany(targetEntity="ReponseTest", mappedBy="question")
     */
    private $reponses;

    
    public function __construct() {
        $this->reponses = new ArrayCollection();
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
     * Set question
     *
     * @param string $question
     * @return TestProprietaire
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add reponses
     *
     * @param \rTC\rTCBundle\Entity\ReponseTest $reponses
     * @return TestProprietaire
     */
    public function addReponse(\rTC\rTCBundle\Entity\ReponseTest $reponses)
    {
        $this->reponses[] = $reponses;

        return $this;
    }

    /**
     * Remove reponses
     *
     * @param \rTC\rTCBundle\Entity\ReponseTest $reponses
     */
    public function removeReponse(\rTC\rTCBundle\Entity\ReponseTest $reponses)
    {
        $this->reponses->removeElement($reponses);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReponses()
    {
        return $this->reponses;
    }
}
