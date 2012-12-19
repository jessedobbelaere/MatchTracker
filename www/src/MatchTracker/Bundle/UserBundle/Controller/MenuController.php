<?php

namespace MatchTracker\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller {

	/**
	 * Generate the user dropdown menu
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function userMenuDropdownAction() {

		$facebookId = $this->get('security.context')->getToken()->getUser()->getFacebookId();
		if(!empty($facebookId)) {
			$profilePicture = "http://graph.facebook.com/" . $facebookId . "/picture?type=square";
		} else {
			$profilePicture = "http://graph.facebook.com/1/picture?type=square";
		}

		return $this->render(
			'MatchTrackerUserBundle:Menu:userMenu.html.twig',
			array('profilePicture' => $profilePicture)
		);
	}
}
