<?php

namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompetitionController extends Controller {
	
	public function indexAction($sport) {
		
		$league = $this->getDoctrine()
    	->getRepository('MatchTrackerBundle:Leagues');
		
		return $this->render('MatchTrackerBundle:Competition:index.html.twig', 
				array('sport' => $sport));
	}
	
	
    public function detailAction($name) {
    	
    	$league = $this->getDoctrine()
    	->getRepository('MatchTrackerBundle:Leagues')
    	->find($name);
    	 
    	
        return $this->render('MatchTrackerBundle:Competition:detail.html.twig', 
        		array('league' => $league));
    }
}
