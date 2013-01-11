<?php

namespace MatchTracker\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
/**
 *
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */
class LeagueRestController extends Controller {

	/**
	 * Get all leagues
	 *
	 * @return mixed
	 */
	public function getLeaguesAction() {
		$leagues = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Leagues')
			->findAll();
//		$leagues = $this->getDoctrine()
//			->getEntityManager()
//			->createQueryBuilder()
//			->select('l.id, l.name, l.description, l.startdate, l.enddate, l.place')
//			->from('MatchTrackerAppBundle:Leagues', 'l')
//			->leftJoin('MatchTrackerAppBundle:Standings', 's')
//			->getQuery()->getResult();
		$view = View::create()
			->setStatusCode(200)
			->setData(array('leagues' => $leagues));

		return $this->get('fos_rest.view_handler')->handle($view);
	}

}
