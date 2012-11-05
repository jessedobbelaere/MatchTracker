<?php

namespace MatchTracker\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompetitionController extends Controller {
	
	public function indexAction($sport) {
		
		$league = $this->getDoctrine()
    	->getRepository('MatchTrackerAppBundle:Leagues');
		
		return $this->render('MatchTrackerAppBundle:Competition:index.html.twig', 
				array('sport' => $sport));
	}
	
	
    public function detailAction($name) {
    	
    	$league = $this->getDoctrine()
    	->getRepository('MatchTrackerAppBundle:Leagues')
    	->find($name);
    	 
    	
        return $this->render('MatchTrackerAppBundle:Competition:detail.html.twig', 
        		array('league' => $league));
    }
}
