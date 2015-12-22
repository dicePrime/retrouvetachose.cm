<?php

namespace rTC\rTCUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('rTCUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
