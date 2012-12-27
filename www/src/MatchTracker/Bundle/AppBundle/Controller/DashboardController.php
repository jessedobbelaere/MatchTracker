<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\Session\Session;
use MatchTracker\Bundle\AppBundle\Entity\Players;

use Doctrine\ORM\EntityRepository;

class DashboardController extends Controller {

<<<<<<< Updated upstream
	/**
	 * Currently logged in user
	 *
	 * @var $user \MatchTracker\Bundle\AppBundle\Entity\Players
	 */
	private $user;
=======
    public function indexAction() {


        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            // user is authenticated

        }
        else{
            return $this->redirect($this->generateUrl('authentication_login'));
        }
>>>>>>> Stashed changes

	/**
	 * Show the dashboard page
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction() {

        // fetch the user
        $this->user = $this->get('security.context')->getToken()->getUser();

        return $this->render('MatchTrackerAppBundle:Dashboard:index.html.twig');

    }

	/**
	 * Profile page
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function profileAction(Request $request) {
		// Get user
		$this->user = $this->get('security.context')->getToken()->getUser();

		// Create profile form
		$form = $this->createFormBuilder($this->user)
			->add('firstname', 'text', array('label' => 'Voornaam', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Voornaam', 'class' => 'input-medium')))
			->add('lastname', 'text', array('label' => 'Familienaam', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Achternaam', 'class' => 'input-large')))
			->add('email', 'text', array('label' => 'E-mailadres', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'E-mail', 'class' => 'input-large')))
			//->add('password', 'password', array('label' => "Paswoord", 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Paswoord', 'class' => 'input-large')))
//			->add('passwordRepeat', 'password', array('label' => 'Paswoord (herhaling)', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Paswoord (herhaling)', 'class' => 'input-large')))
			->getForm();


		// If profile form is submitted...
		if ($request->isMethod('POST')) {
			$form->bind($request);
			$data = $form->getData();

			// Form data is correct, so start your engines!
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($this->user);
				$em->flush();

				// Redirect
				return $this->redirect($this->generateUrl('dashboard'));
			}

		}

		// Render the view
		return $this->render('MatchTrackerAppBundle:Dashboard:profile.html.twig', array(
			"form" => $form->createView()));
	}

	public function competitionsAction() {
		// Get user
		$this->user = $this->get('security.context')->getToken()->getUser();

		// fetch the competitions related to the user
		$leagues = $this->getDoctrine()
			->getRepository('MatchTrackerAppBundle:Leagues')
			->findBy(array('user' => $this->user));

		return $this->render('MatchTrackerAppBundle:Dashboard:competitions.html.twig',
			array('leagues' => $leagues)
		);

	}

	
	



}
