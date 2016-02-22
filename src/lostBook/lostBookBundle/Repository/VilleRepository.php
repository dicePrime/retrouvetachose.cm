<?php

namespace lostBook\lostBookBundle\Repository;


/**
 * Description of VilleRepository
 *
 * @author ndziePatrick
 */

use Doctrine\ORM\EntityRepository;

class VilleRepository extends EntityRepository {
    
    /**
     * Cette fonction retourne toutes les annonces relatives
     * à une ville
     */
    public function getAnnonces($idVille)
    {
       //il s'agira de faire une requête dans la liste des annonces avec pour
       //condition que l'id de la ville soit $idVille
    }
    
    
    /**
     * Cette fonction retourne tous les espaces dédiés
     * associés à une ville.
     */
    public function getEspacesDedies($idVille)
    {
        
    }
}
