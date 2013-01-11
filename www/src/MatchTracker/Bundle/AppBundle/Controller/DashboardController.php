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
use MatchTracker\Bundle\AppBundle\Form\TeamsType;
use MatchTracker\Bundle\AppBundle\Entity\Matches;

use Doctrine\ORM\EntityRepository;

class DashboardController extends Controller {

	/**
	 * Currently logged in user
	 *
	 * @var $user \MatchTracker\Bundle\AppBundle\Entity\Players
	 */
	private $user;

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

    /**
     * Invite teams to your competition
     *
     * @param $nameCanonical
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teamsAction($nameCanonical, Request $request) {
        $competition = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Leagues')
            ->findOneBy(array('nameCanonical' => $nameCanonical));

        $builder = $this->createFormBuilder($competition);
        $form = $builder->add('teams', 'collection', array(
            'label' => 'Teams',
            'label_attr' => array('class' => 'control-label'),
            'type' => new TeamsType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ))->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                $teams = $competition->getTeams();

                // Send an invitation to the teams
                foreach ($teams as $team) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Hello Email')
                        ->setFrom('noreply@matchtracker.be')
                        ->setTo($team->getEmail())
                        ->setBody($this->renderView(
                            'MatchTrackerAppBundle:Mails:index.html.twig',
                            array('team' => $team)
                        )
                    );
                    $this->get('mailer')->send($message);
                }


                // Save changes to db
                $em = $this->getDoctrine()->getManager();
                $em->persist($competition);
                $em->flush();

                // Redirect to new canonical url
                // return $this->redirect($this->generateUrl('mycompetitions'));
            }

        }

        return $this->render('MatchTrackerAppBundle:Dashboard:teams.html.twig',
            array(
                'competition' => $competition,
                'form' => $form->createView()
            )
        );

    }


    /*
     *
     *
     * */
    public function scheduleAction($nameCanonical, Request $request) {

        $league = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Leagues')
            ->findOneBy(array('nameCanonical' => $nameCanonical));

        $startDate = strtotime($league.startDate());
        $endDate =  strtotime($league.endDate());

        $teams = $league->getTeams();

        while( $startDate <= $endDate ) {
            $startDate = strtotime( "+1 week", $startDate );

            do {
                $homeTeam = rand(0, $teams.lengh);
                $awayTeam = rand(0, $teams.lengh);
            } while ($homeTeam == $awayTeam);

            $match = new Matches();

            $match->setHomeTeam($teams[$homeTeam]->getId());
            $match->setAwayTeam($teams[$awayTeam]->getId());
            $match->setDate($startDate);


            // Save changes to db
            $em = $this->getDoctrine()->getManager();
            $em->persist($match);
            $em->flush();


            array_splice($teams, $homeTeam);
            array_splice($teams, $awayTeam);


            return $this->render('MatchTrackerAppBundle:Dashboard:teams.html.twig');

        }

    }
	



}
