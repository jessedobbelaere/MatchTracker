<?php

namespace MatchTracker\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
class MatchRestController extends Controller {

	public function getMatchesAction() {
		$matches = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Matches')
			->findby(array('finished' => '0'), array('startTime' => 'asc'));

		$view = View::create()
			->setStatusCode(200)
			->setData(array('matches' => $matches));

		return $this->get('fos_rest.view_handler')->handle($view);
	}

	public function getMatchAction($id) {
		$match = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Matches')
			->findById($id);

		$view = View::create()
			->setStatusCode(200)
			->setData(array('matches' => $match));

		return $this->get('fos_rest.view_handler')->handle($view);
	}


}
