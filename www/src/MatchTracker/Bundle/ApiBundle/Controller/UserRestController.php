<?php

namespace MatchTracker\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;

/**
 * Users REST API controller
 *
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */
class UserRestController extends Controller {

	/**
	 * Get currently logged in user
	 *
	 * @return mixed
	 */
	public function getUsersAction() {
		$user = $this->get('security.context')->getToken()->getUser();

		$view = View::create()
			->setStatusCode(200)
			->setData($user);

		return $this->get('fos_rest.view_handler')->handle($view);
	}

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
				->setData($sports);

		return $this->get('fos_rest.view_handler')->handle($view);
	}
}
