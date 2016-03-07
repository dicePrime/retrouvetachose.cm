<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lostBook\lostBookBundle\Commons;

/**
 * Description of CommonsTasks
 *
 * @author ndziePatrick
 */
class CommonsTasks {
    //put your code here
    public static function moveFile($sourcePath,$destinationPath,$baseName)
    {
        try{
            $destination = $destinationPath.'/'.$baseName;
            return rename($sourcePath,$destination);
        }
        catch(\Exception $ex)
        {
            $monfichier = fopen('moveFileException.txt','w+');
            fputs($monfichier,print_r($ex->getMessage(),true));
            fclose($monfichier);
            return false;
        }

        
    }
    
     public static function deleteDir($dir) {
        if (is_dir($dir)) { 
        $objects = scandir($dir); 
        foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
                if (filetype($dir."/".$object) == "dir") CommonTask::deleteDir($dir."/".$object);
                else unlink($dir."/".$object); 
            } 
        }
        reset($objects); 
        rmdir($dir); 
    }
        
    }

    /**
     * @param \DateTime $start_date
     * @param \DateTime $end_date
     * @return array
     */
  public static function date_difference(\DateTime $start_date,\DateTime $end_date) {
  if($end_date > $start_date)
  {
    $intervalle = $start_date->diff($end_date);
    $d = $intervalle->d;
    $h = $intervalle->h;
    $m = $intervalle->i; 
    
//Since you need just hours and mins
  return array('days'=>$d,'hours'=>$h);
  
  }
  else{
      return array('days'=>'N/A','hours'=>'N/A');
  }
}

public static function executeQuery($connexion,$query,$array)
{
    $req = $connexion->prepare($query);
   
    try {
        $req->execute($array);
        return $req;
        }
    catch(\Exception $ex)
    {
        $monfichier = fopen('dbexceptions/executeQueryException.txt');
        return null;
    }

}

public static function getVehicules($connexion)
{
   $resultat = array();    
   $req = $connexion->prepare(Queries::$getVehicules);
   $req->execute();
   
   while($donnees = $req->fetch())
   {
       $tmp = new Vehicule();
       $tmp->setIdVehicule($donnees['ID_VEHICULE']);
       $tmp->setImmatriculation($donnees['IMMATRICULATION']);
       $tmp->setMarque($donnees['MARQUE']);
       $tmp->setModele($donnees['MODELE']);
       $tmp->setKilometrage($donnees['KILOMETRAGE']);
       $tmp->setRegion($donnees['REGION']);
       $tmp->setDirection($donnees['DIRECTION']);
       $tmp->setPool($donnees['POOL']);
       
       $resultat[] = $tmp;
   }
   return $resultat; 
}

public static function getVehiculesByDirection($direction,$vehicules)
{
   $resultat = array();
   
   foreach($vehicules as $vehicule)
   {
       if($vehicule->getDirection() == $direction)
       {
           $resultat[] = $vehicule;
       }
   }
   
   return $resultat;
}

public static function isVehiculeDAL($immatriculation,$vehiculesDAL)
{
    $resultat = false;
    foreach($vehiculesDAL as $vehicule)
    {
        if(trim($immatriculation) == trim($vehicule->getImmatriculation()))
        {
            return true;
        }
    }
    
    return $resultat;
}

/**
 * Cette fonction renvoie à partir d'un tableau 
 * contenant tous les véhicules, la liste des véhicules en charge
 * DAl,
 * Les véhicules en charge DAL ont les carétéristiques suivantes:
 * POOL != 'N\A'
 * et region != 'LITTORAL' (en majuscules pas Littoral)
 * et direction != 'DGG'
 * @param type $vehicules
 */

public static function getVehiculesDAL($vehicules)
{
    $resultat = array();
    
    foreach($vehicules as $vehicule)
    {
        $condition = $vehicule->getPool() != 'N\A' && $vehicule->getRegion() != 'LITTORAL' && $vehicule->getDirection() != 'DGG';
        if($condition)
        {
            $resultat[] = $vehicule;
        }
    }
    
    return $resultat;
}

public static function getVehiculesOCM($vehicules)
{
  $resultat = array();
  
  foreach($vehicules as $vehicule)
  {
    $condition = $vehicule->getPool() == 'N\A' || $vehicule->getRegion() == 'LITTORAL' || $vehicule->getDirection() == 'DGG';
  
    if($condition)
    {
        $resultat[] = $vehicule;
    }
    
  }
  return $resultat;
}

    public static function uploadFile($formName,$tmpDir)
    {
        $monfichier = fopen('testUpload.txt','w+');
        fputs($monfichier,print_r($_FILES,true));
        fclose($monfichier);
        $sourcePath = null;
        $targetPath = null;
        if (is_array($_FILES))
        {
            if (is_uploaded_file($_FILES[$formName]['tmp_name']))
                {
                $sourcePath = $_FILES[$formName]['tmp_name'];
                if(file_exists($tmpDir)) CommonTask::deleteDir($tmpDir);
                mkdir($tmpDir);
                $targetPath = $tmpDir . $_FILES[$formName]['name'];
                }
        }
        return move_uploaded_file($sourcePath, $targetPath);
    }
    
    public static function getRegionsArray($region)
    {
        $tableau = preg_split("#;#", $region);
        return $tableau;
    }
    
    /**
     * Cette fonction construit le commentaire qui doit �tre enregistr� dans la base 
     * de donn�es
     * On separe les differentes partie du commentaire par *-* et les commentaires par *-*-*
     * @param string $oldComments les anciens commentaires de validation
     * @param string $newComment le commentaire de l'utilsateur actuel
     * @param string $userName le nom de l'utilisateur
     * @param string $date la date � laquelle le commentaire actuel est fait
     */
    public static function constructComment($oldComments,$newComment,$userName,$date)
    {
    	//On separe les differentes partie du commentaire par :: et les commentaires par :::
    	if($oldComments != NULL)
    	{
    		$news = $userName.'::'.$date.'::'.$newComment;
    		$resultat = $oldComments.$news.':::';
    		return $resultat;
    	}
    	else
    	{
    		if($newComment != NULL)
    		{
    			
    			$resultat = $userName.'::'.$date.'::'.$newComment.':::';
    			return $resultat;
    		}
    		else
    		{
    			return null;
    		}
    		
    	}
    }
    /**
     * On separe les differentes partie du commentaire par *-* et les commentaires par *-*-*
     * @param string $commentaire
     * @return array : le tableau des commentaires
     */
    
    public static function recontructComment($commentaire)
    {
    	if ($commentaire != null) {
    		$comments = array();
    		$tableau = preg_split("#:::#", $commentaire);
    		$taille = count($tableau);
    		$i = 0;
    		$j = 0;
    		while ($i < $taille) {
    			$tmp = preg_split("#::#", $tableau[$i]);
    			$taille1 = count($tmp);
    			if ($taille1 >= 3) {
    				$comments[$j]['nom'] = $tmp[0];
    				$comments[$j]['commentaire'] = $tmp[2];
    				$comments[$j]['date'] = $tmp[1];
    				$j++;
    			}
    			$i++;
    		}
    		return $comments;
    	} else {
    		return null;
    	}
    }
    
    
    public static function createWatermarkImage($sourceImage,$extension,$watermark,$sxFactor,$syFactor,$output,$date)
    {           
        $font ="fonts/arial.ttf";
        try{
        if(strtoupper($extension) == 'PNG')
        {
            $im = imagecreatefrompng($sourceImage);
            $watermarkImg = imagecreatefrompng($watermark);
            $sx =$sxFactor*(imagesx($im)- imagesx($watermarkImg));
            $sy = $syFactor*(imagesy($im) - imagesy($watermarkImg));
            imagecopymerge($im, $watermarkImg,$sx,$sy,0,0,imagesx($watermarkImg),imagesy($watermarkImg),50);
            $imgSy = $sy - 10;
            imagettftext($im,5,0, $sx+5, $imgSy,0x0000FF,$font, $date);
            imagepng($im,$output);
                          
        }
        else if(strtoupper($extension) == 'JPG')
        {
            $im = imagecreatefromjpeg($sourceImage);
            $watermarkImg = imagecreatefrompng($watermark);
            $sx =$sxFactor*(imagesx($im)- imagesx($watermarkImg));
            $sy = $syFactor*(imagesy($im) - imagesy($watermarkImg));
            imagecopymerge($im, $watermarkImg,$sx,$sy,0,0,imagesx($watermarkImg),imagesy($watermarkImg),50);
            $imgSy = $sy - 10;
            imagettftext($im,5,0, $sx+5, $imgSy,0x0000FF,$font, $date);
            imagejpeg($im,$output);
            
        }
        }
        catch(\Exception $ex)
        {
            $monfichier = fopen("createWatermarkImageException.txt","w+");
            fputs($monfichier,print_r($ex->getMessage(),true));
            fclose($monfichier);
        }
        
        
    }
    
    public static function writeFile($fileName,$message,$mode)
    {
        $monfichier = fopen($fileName,$mode);
        fputs($monfichier,print_r($message,true));
        fclose($monfichier);
    }
    
}
