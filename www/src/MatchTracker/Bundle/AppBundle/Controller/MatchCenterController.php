<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraints as Assert;

class MatchCenterController extends Controller {

    /**
     * Matchecenter: overview
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {
        $matches = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
        ->findBy(array('finished' => '0'),array('date' => 'ASC', 'startTime' => 'ASC'))
        ;

		return $this->render('MatchTrackerAppBundle:MatchCenter:index.html.twig',
            array('matches' => $matches));
	}


    /**
     * Matchcenter: detail
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Match report system
     *
     * @param $id
     * @param $player
     * @param $event
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportAction($id, $player, $event, Request $request) {
        // fetch the competitions related to the user

        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);


        $matchEvents = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:MatchEvents')
            ->findAll();


        return $this->render('MatchTrackerAppBundle:MatchCenter:report.html.twig',
            array(
                'match' => $match,
                'matchEvents' => $matchEvents,
                'player' => $player,
                'event' => $event,
                'id' => $id
            )
        );
    }

    /**
     * Add event
     *
     * @param $id
     * @param $player
     * @param $event
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addEventAction($id, $player, $event, Request $request) {
        $matchHasEvent = new \MatchTracker\Bundle\AppBundle\Entity\MatchesHasMatchEvents();

        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);

        $matchEvent = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:MatchEvents')
            ->find($event);

        $matchPlayer = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Players')
            ->find($player);

        $teams = $matchPlayer->getTeams();
        foreach ($teams as $team) $matchTeam = $team;

        $matchHasEvent->setTime(0);
        $matchHasEvent->setMatchEvents($matchEvent);
        $matchHasEvent->setMatches($match);
        $matchHasEvent->setPlayers($matchPlayer);
        $matchHasEvent->setTeams($matchTeam);

        $em = $this->getDoctrine()->getManager();
        $em->persist($matchHasEvent);

        // Update score
        if ($event == 1) {
            if ($team === $match->getAwayTeam()) {
                $score = $match->getAwayScore();
                $match->setAwayScore(($score + 1));
            } else if ($team === $match->getHomeTeam()) {
                $score = $match->getHomeScore();
                $match->setHomeScore(($score + 1));
            }
        } else if ($event == 2) {
            if ($team === $match->getAwayTeam()) {
                $score = $match->getHomeScore();
                $match->setHomeScore(($score + 1));
            } else if ($team === $match->getHomeTeam()) {
                $score = $match->getAwayScore();
                $match->setAwayScore(($score + 1));
            }
        }

        $em->persist($match);
        $em->flush();

        return $this->redirect($this->generateUrl('matchcenter_report', array('id' => $id)));

    }

    /**
     * End of the match
     *
     * @param $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function endEventAction($id, Request $request) {
        // Get match
        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);

        $match->setActive('0');
        $match->setFinished('1');

        $em = $this->getDoctrine()->getManager();
        $em->persist($match);
        $em->flush();

        return $this->redirect($this->generateUrl('matchcenter_report', array('id' => $id)));
    }

    /**
     * Lets start the match
     *
     * @param $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function startEventAction($id, Request $request) {

        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);

        if( $match->getHomeScore() === null) {
            $match->setHomeScore(0);
        }
        if( $match->getAwayScore() === null) {
            $match->setAwayScore(0);
        }



        //$match->setStartTime(date("G:i:s"));
        $match->setActive('1');
        $match->setFinished('0');

        $em = $this->getDoctrine()->getManager();
        $em->persist($match);
        $em->flush();

        return $this->redirect($this->generateUrl('matchcenter_report', array('id' => $id)));
    }

}
