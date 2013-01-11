<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function reportAction($id, $request) {
        // fetch the competitions related to the user
       /*
        $match = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Matches')
            ->find($id);

        $MatchEvents = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:MatchesHasMatchEvents')
            ->findBy(array('matches' => $id), array('time' => 'desc'));

        $builder = $this->createFormBuilder($MatchEvents);
        $form = $builder->add('event', 'collection', array(
            'label' => 'Events',
            'label_attr' => array('class' => 'control-label'),
            'type' => new TeamsType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ))->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {


            }

        }


        return $this->render('MatchTrackerAppBundle:MatchCenter:report.html.twig',
            array(
                'form' => $form
            )
        );*/
    }
}
