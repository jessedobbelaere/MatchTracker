<?php

namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {
	
    public function indexAction() {
        return $this->render('MatchTrackerBundle:Page:index.html.twig');
    }
}
