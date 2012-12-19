<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {
	
    public function indexAction() {
        return $this->render('MatchTrackerAppBundle:Page:index.html.twig');
    }
}
