<?php

namespace Queue\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('QueueDataBundle:Default:index.html.twig', array('name' => $name));
    }
}
