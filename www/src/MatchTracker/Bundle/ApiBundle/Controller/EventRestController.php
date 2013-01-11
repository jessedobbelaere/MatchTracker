<?php

namespace MatchTracker\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
class EventRestController extends Controller {

	public function getEventsAction($id) {
		$events = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:MatchesHasMatchEvents')
			->findby(array('matches' => $id));

		$view = View::create()
			->setStatusCode(200)
			->setData(array('events' => $events));

		return $this->get('fos_rest.view_handler')->handle($view);
	}

}
