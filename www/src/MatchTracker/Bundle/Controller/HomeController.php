<?php

namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {
	
    public function indexAction() {
        return $this->render('MatchTrackerBundle:Home:index.html.twig');
    }
}
