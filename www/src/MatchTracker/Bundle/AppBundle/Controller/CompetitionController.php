<?php

namespace MatchTracker\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Session;
use MatchTracker\Bundle\AppBundle\Entity\Leagues;
use MatchTracker\Bundle\AppBundle\Form\LeaguesType;
use Symfony\Component\Form\FormError;

/**
 * Competition Controller
 */
class CompetitionController extends Controller {

    /**
     * Competition summary with or without filter
     *
     * @param $sport
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($sport) {
		return $this->render('MatchTrackerAppBundle:Competition:index.html.twig', 
				array('sport' => $sport));
	}

    /**
     * Detail view of a competition
     *
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailAction($name) {
    	
    	$league = $this->getDoctrine()
    	->getRepository('MatchTrackerAppBundle:Leagues')
    	->find($name);
    	
        return $this->render('MatchTrackerAppBundle:Competition:detail.html.twig', 
        		array('league' => $league));
    }

    /**
     * Competition maker step1: general info
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function makerAction(Request $request) {
        // Form constraints
        $constraint = new Assert\Collection(array(
            'name' => new Assert\NotBlank(array('message' => 'Gelieve naam in te vullen')),
            'description' => new Assert\NotBlank(array('message' => 'Gelieve beschrijving in te vullen')),
            'startdate' => array(
                new  Assert\Date(array('message' => 'Gelieve een datum aan te duiden')),
                new  Assert\NotBlank(array('message' => 'Gelieve een datum in te vullen'))),
            'enddate' => array(
                new  Assert\Date(array('message' => 'Gelieve een datum aan te duiden')),
                new  Assert\NotBlank(array('message' => 'Gelieve een datum in te vullen'))),
        ));

        // Create form with constraints
        $form = $this->createFormBuilder(null, array('validation_constraint' => $constraint))
            ->add('name', 'text', array('label' => 'Naam', 'attr' => array()))
            ->add('description', 'textarea', array('label' => 'Beschrijving', 'attr' => array()))
            ->add('startdate', 'date', array('widget' => 'single_text', 'label' => 'Start datum (dd-mm-jjjj)', 'format' => 'dd-MM-yyyy', 'attr' => array('data-date-format' => 'dd/mm/yyyy', 'value' => (date('d-m-Y')))))
            ->add('enddate', 'date', array('widget' => 'single_text', 'label' => 'Eind datum (dd-mm-jjjj)', 'format' => 'dd-MM-yyyy', 'attr' => array('value' => (date('d-m-Y', time() + 86400)))))
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();

            // End date must by later then start date
            if ($data['startdate'] >  $data['enddate']){
                 $form->get('enddate')->addError(new FormError('Eind datum moet na de start datum zijn'));
             }

            if ($form->isValid()) {

                // New competition
                $competition = new Leagues();
                $competition->setName($data["name"]);
                $competition->setDescription($data["description"]);
                $competition->setStartdate($data['startdate']);
                $competition->setEnddate($data['enddate']);

                // Put competition in session
                $this->get('session')->set('competition', $competition);

                // Redirect to step 2
                return $this->redirect($this->generateUrl('competition_maker_details', array('sport' => 'sport')));
            }

        }

        return $this->render('MatchTrackerAppBundle:Competition:maker.html.twig', array(
            "form" => $form->createView()));
    }

    /**
     * Competition maker step 2: detailed info
     *
     * @param $sport
     * @param $type
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function makerDetailAction($sport, $type, Request $request) {
        // Redirect if there's no competition in session
        $competition = $this->get('session')->get('competition');
        if ($competition === null) {
            return $this->redirect($this->generateUrl('competition_maker'));
        }

        // Get sportTypes
        $sportTypes = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:SportTypes')->findAll();

        // Create sports structuur
        $sportTypesArray = array();
        foreach ($sportTypes as $sportType) {
            $sportTypesArray[$sportType->getSports()->getName()][] = $sportType->getName();
        }

        // Form will not be created until a sport type is selected
        if ($type !== 'null') {
            $sportType = $this->getDoctrine()
                ->getRepository('MatchTrackerAppBundle:SportTypes')->findOneByName($type);

            // Create LeaguesType form
            $form = $this->createForm(new LeaguesType($sport, $sportType));

            if ($request->isMethod('POST')) {
                $form->bind($request);
                $data = $form->getData();

                if ($form->isValid()) {
                    $this->get('session')->remove('competition');

                    $competition->setUser($this->getUser());
                    $competition->setSportTypes($sportType);
                    $competition->setNumberOfTeams($data['numberOfTeams']);

                    if ($sportType->getPlayersOnField() != null) {
                        $competition->setPlayersOnField($sportType->getPlayersOnField());
                    } else {
                        $competition->setPlayersOnField($data['playersOnField']);
                    }

                    if ($data['location'] === 'one') {
                        $competition->setFields($data['field']);
                        $competition->setPlace($data['place']);
                    }

                    // perform some action, such as saving the task to the database
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($competition);
                    $em->flush();

                    //return $this->redirect($this->generateUrl('competition_maker_details'));
                }
            }

        }

        // Items to render with template
        $toRender = array('sportTypes' => $sportTypesArray,
            'sport' => $sport,
            'type' => $type);
        if ($type !== 'null') {
            $toRender['form'] = $form->createView();
        }
        return $this->render('MatchTrackerAppBundle:Competition:maker_details.html.twig', $toRender);
    }
}
