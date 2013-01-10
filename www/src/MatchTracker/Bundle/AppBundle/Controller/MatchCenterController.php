<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MatchCenterController extends Controller {

	public function indexAction() {
		return $this->render('MatchTrackerAppBundle:MatchCenter:index.html.twig');
	}
}
