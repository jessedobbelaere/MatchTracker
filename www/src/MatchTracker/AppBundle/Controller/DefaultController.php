<?php

namespace MatchTracker\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MatchTrackerAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
