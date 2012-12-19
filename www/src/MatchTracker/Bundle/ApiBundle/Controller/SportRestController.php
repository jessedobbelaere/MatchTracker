<?php

namespace MatchTracker\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;

/**
 * Users REST API controller
 *
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */
class SportRestController extends Controller {

	/**
	 * Get all sports
	 *
	 * @return mixed
	 */
	public function getSportsAction() {
		$sports = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Sports')
			->findAll();

		$view = View::create()
			->setStatusCode(200)
			->setData(array('sports' => $sports));

		return $this->get('fos_rest.view_handler')->handle($view);
	}

	/**
	 * Get one specific sport
	 *
	 * @param $id
	 * @return mixed
	 */
	public function getSportAction($id) {
		$sport = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Sports')
			->find($id);

		$view = View::create()
			->setStatusCode(200)
			->setData(array("sport" => $sport));

		return $this->get('fos_rest.view_handler')->handle($view);
	}

}
