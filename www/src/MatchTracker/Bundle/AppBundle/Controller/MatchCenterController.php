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

    public function reportAction($id, Request $request) {
        // fetch the competitions related to the user

        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);


        $matchEvents = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:MatchEvents')
            ->findAll();

        $playersArray = array();

        foreach ($match->getHomeTeam()->getPlayers() as $player) {
            $playersArray[$player->getId()] = ($player->getNumber() . ': ' . $player->getName());
        }

        foreach ($match->getAwayTeam()->getPlayers() as $player) {
            $playersArray[$player->getId()] = ($player->getNumber() . ': ' . $player->getName());
        }

        $constraint = new Assert\Collection(array(
            'player' => array(
                new Assert\NotBlank(array('message' => 'Gelieve aantal velden in te vullen'))),
            'event' => array(
                new Assert\NotBlank(array('message' => 'Gelieve aantal velden in te vullen'))),
            'time' => array(
                new Assert\NotBlank(array('message' => 'Gelieve aantal velden in te vullen')))
        ));

        $eventArray = array();
        foreach ($matchEvents as $event) {
            $eventArray[$event->getId()] = $event->getName();
        }

        $form = $this->createFormBuilder(null, array('validation_constraint' => $constraint))
            ->add('player', 'choice', array('choices' => $playersArray,'label' => 'Speler'))
            ->add('event', 'choice', array('choices' => $eventArray,'label' => 'Actie'))
            ->add('time', 'integer', array('label' => 'Tijd',))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();

            if ($form->isValid()) {

                $matchEvents = $this->getDoctrine()
                    ->getRepository('MatchTrackerAppBundle:MatchEvents')
                    ->find($data['event']);

                $player = $this->getDoctrine()
                    ->getRepository('MatchTrackerAppBundle:Players')
                    ->find($data['player']);

                $teams = $player->getTeams();


                $matchHasEvent = new \MatchTracker\Bundle\AppBundle\Entity\MatchesHasMatchEvents();

                $matchHasEvent->setTime($data['time']);
                $matchHasEvent->setMatchEvents($matchEvents);
                $matchHasEvent->setMatches($match);
                $matchHasEvent->setPlayers($player);
                $matchHasEvent->getTeams($teams[0]);

                $em = $this->getDoctrine()->getManager();
                $em->persist($matchHasEvent);
                $em->flush();
            }

        }


        return $this->render('MatchTrackerAppBundle:MatchCenter:report.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
}
