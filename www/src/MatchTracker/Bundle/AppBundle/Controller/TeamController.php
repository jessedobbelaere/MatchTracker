<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

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
	public function editAction($nameCanonical, $code, Request $request) {

		/**
		 * Team object
		 * @var $team \MatchTracker\Bundle\AppBundle\Entity\Teams
		 */
		$team = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Teams')
			->findOneBy(array('nameCanonical' => $nameCanonical));

		// Security check
		if($team == null || ($code !== $team->getCode())) {
			return $this->redirect($this->generateUrl('homepage'));
		}

		// Create form with constraints
		$form = $this->createFormBuilder(null)
			->add('name', 'text', array('label' => 'Naam', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Naam'), 'data' => $team->getName()))
			->getForm();

		if ($request->isMethod('POST')) {
			$form->bind($request);
			$data = $form->getData();

			// Form is valid?
			if ($form->isValid()) {
				$team->setName($data['name']);
				$team->generateNameCanonical();

				// Save changes
				$em = $this->getDoctrine()->getManager();
				$em->persist($team);
				$em->flush();

				// Redirect to new canonical url
				return $this->redirect($this->generateUrl('team_edit', array('nameCanonical' => $team->getNameCanonical(), 'code' => $team->getCode())));
			}

		}

		// Render view
		return $this->render('MatchTrackerAppBundle:Team:edit.html.twig',
			array(
				'team' => $team,
				'form' => $form->createView()
			));
	}

}