<?php

namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller {

	public function indexAction() {
		return $this->render('MatchTrackerBundle:Profile:index.html.twig');
	}
}