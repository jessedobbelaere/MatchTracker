<?php

namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompetitionController extends Controller {
	
	public function indexAction($sport) {
		
		// database filteren op sport en meegeven naar twig pagina, daar itereren
		
		return $this->render('MatchTrackerBundle:Competition:index.html.twig', array('sport' => $sport));
	}
	
	
    public function detailAction($name) {
    	
    	// competitie uit db halen volgens $name
    	
        return $this->render('MatchTrackerBundle:Competition:detail.html.twig', array('name' => $name));
    }
}
