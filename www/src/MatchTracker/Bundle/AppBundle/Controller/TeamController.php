<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TeamController extends Controller {

	/**
	 * Team overview page
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction() {
		return $this->render('MatchTrackerAppBundle:Team:index.html.twig');
	}

	/**
	 * Team edit page
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editAction($nameCanonical, $code) {

		/**
		 * Team object
		 * @var $team \MatchTracker\Bundle\AppBundle\Entity\Teams
		 */
		$team = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Teams')
			->findOneByNameCanonical($nameCanonical);



		return $this->render('MatchTrackerAppBundle:Team:edit.html.twig');
	}

}