<?php

namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {

	public function indexAction() {
		return $this->render('MatchTrackerBundle:Dashboard:index.html.twig');
	}
}