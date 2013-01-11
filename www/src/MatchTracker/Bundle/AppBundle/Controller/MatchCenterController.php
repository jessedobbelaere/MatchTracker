<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MatchCenterController extends Controller {

	public function indexAction() {
		return $this->render('MatchTrackerAppBundle:MatchCenter:index.html.twig');
	}

    public function detailAction($id) {
        // fetch the competitions related to the user
        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);

        $events = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:MatchesHasMatchEvents')
            ->findBy(array('matches' => $id), array('time' => 'desc'));

        return $this->render('MatchTrackerAppBundle:MatchCenter:detail.html.twig',
            array(
                'match' => $match,
                'events' => $events
            )
        );
    }
}
