<?php

namespace lostBook\lostBookUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('lostBookUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
