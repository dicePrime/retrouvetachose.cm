<?php
namespace lostBook\lostBookBundle\EventListener;
use Oneup\UploaderBundle\Event\PreUploadEvent;
use Symfony\Component\HttpFoundation\UploadedFile;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UploadListener
 *
 * @author ndziePatrick
 */
class UploadListener
{

    /*public function preUpload(PreUploadEvent $event)
    {
        //...
        $session = $event->getRequest()->getSession();
        if($session->get('uploadedFiles') == NULL)
        {
            $session->set('uploadedFiles', array());
        }
        $file = $event->getFile();
        $uploadedFiles = $session->get("uploadedFiles");
        $newFile = new \lostBook\lostBookBundle\Entity\Document();
        $newFile->setFileName($file->getFileName());
        $newFile->setFileSize($file->getSize());
        $newFile->setPathName($file->getPathName());
        $newFile->setMimeType($file->getMimeType());
        $extensions = preg_split("#/#",$newFile->getMimeType());
        $newFile->setFileExtension($extensions[1]);
        $uploadedFiles[] = $newFile;
        $session->set('uploadedFiles',$uploadedFiles);

    }*/



}
