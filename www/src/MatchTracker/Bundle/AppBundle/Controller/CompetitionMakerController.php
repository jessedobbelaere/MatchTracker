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
 * CompetitionMaker Controller
 */
class CompetitionMakerController extends Controller {

    /**
     * Competition maker step1: general info
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request) {
        $competition = $this->get('session')->get('competition');
        if ($competition !== null) {
            $this->get('session')->remove('competition');
        }

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
            ->add('name', 'text', array('label' => 'Naam', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Naam')))
            ->add('description', 'textarea', array('label' => 'Beschrijving', 'label_attr' => array('class' => 'control-label'), 'attr' => array('placeholder' => 'Beschrijving', 'class' => 'span6', 'rows' => 5)))
            ->add('startdate', 'date', array('widget' => 'single_text', 'label' => 'Start datum', 'label_attr' => array('class' => 'control-label'), 'format' => 'dd-MM-yyyy', 'attr' => array('data-date-format' => 'dd/mm/yyyy', 'value' => (date('d-m-Y')))))
            ->add('enddate', 'date', array('widget' => 'single_text', 'label' => 'Eind datum', 'label_attr' => array('class' => 'control-label'), 'format' => 'dd-MM-yyyy', 'attr' => array('value' => (date('d-m-Y', time() + 86400)))))
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();

            // End date must by later then start date
            if ($data['startdate'] >  $data['enddate']){
                 $form->get('enddate')->addError(new FormError('Eind datum moet na de start datum zijn'));
             }

            // Check if name is valid
            $league = $this->getDoctrine()
                ->getRepository('MatchTrackerAppBundle:Leagues')
                ->findOneByName($data["name"]);

            if ($league !== null){
                $form->get('name')->addError(new FormError('Naam is al in gebruik'));
            } else {
                // Check if canonical of name is valid
                $league = $this->getDoctrine()
                    ->getRepository('MatchTrackerAppBundle:Leagues')
                    ->findOneBy(array('nameCanonical' => \MatchTracker\Bundle\AppBundle\Utils\Utils::canonicalize($data["name"])));

                if ($league !== null){
                    $form->get('name')->addError(new FormError('Naam is al in gebruik'));
                }
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
                return $this->redirect($this->generateUrl('competition_maker_sport'));
            }

        }

        return $this->render('MatchTrackerAppBundle:CompetitionMaker:index.html.twig', array(
            "form" => $form->createView()));
    }


    /**
     * Competition maker step2: choose sport
     *
     * @param $type
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function sportAction($type, Request $request) {
        // Redirect if there's no competition in session
        $competition = $this->get('session')->get('competition');
        if ($competition === null) {
            return $this->redirect($this->generateUrl('competition_maker'));
        }

        if ($type != null) {
            // find sportType by id
            $sportType = ($this->getDoctrine()
                ->getRepository('MatchTrackerAppBundle:SportTypes')->find($type));
            $competition->setSportTypes($sportType);

            $this->get('session')->set('competition', $competition);

            return $this->redirect($this->generateUrl('competition_maker_formula'));
        }

        // Get sportTypes
        $sportTypes = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:SportTypes')->findAll();

        // Create sports structure
        $sportTypesArray = array();
        foreach ($sportTypes as $sportType) {
            $sportTypesArray[$sportType->getSports()->getName()][$sportType->getName()] = $sportType->getId();
        }

        return $this->render('MatchTrackerAppBundle:CompetitionMaker:sport.html.twig', array('sportTypes' => $sportTypesArray));

    }

    /**
     * Competition maker step3: choose formula
     *
     * @param $formula
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function formulaAction($formula, Request $request) {
        // Redirect if there's no competition in session
        $competition = $this->get('session')->get('competition');
        if ($competition === null) {
            return $this->redirect($this->generateUrl('competition_maker'));
        }

        // Redirect if sportType isn't set
        if ($competition->getSportTypes() === null) {
            return $this->redirect($this->generateUrl('competition_maker_sport'));
        }

        // Form will not be created until a sport type is selected
        if ($formula !== 'null') {

            // Create LeaguesType form
            $form = $this->createForm(new LeaguesType($formula, ($competition->getSportTypes()->getPlayersOnField() == null)));

            if ($request->isMethod('POST')) {
                $form->bind($request);
                $data = $form->getData();

                // Check invalid combination
                if ($formula === 'beide') {
                    // No odd-numbered groups
                    if ((int)$data['numGroups'] !== 0 && (int)$data['numberOfTeams'] !== 0) {
                        if ((double)((double)$data['numberOfTeams'] % (double)$data['numGroups']) != 0) {
                            $form->get('numGroups')->addError(new FormError('Oneven aantal ploegen per groep'));
                            $form->get('numberOfTeams')->addError(new FormError('Oneven aantal ploegen per groep'));
                        }

                        // More than 2 teams per group
                        if ((double)((double)$data['numberOfTeams'] / (double)$data['numGroups']) <= 2) {
                            $form->get('numGroups')->addError(new FormError('Te weinig ploegen per groep'));
                            $form->get('numberOfTeams')->addError(new FormError('Te weinig ploegen per groep'));
                        }
                    }
                }

                if ($form->isValid()) {

                    $competition->setNumberOfTeams($data['numberOfTeams']);
                    $competition->setReturnMatch(($data['returnMatch'] === 'true' ? 1 : 0));

                    // If players on field isn't set in sporttype use data from form
                    if ($competition->getSportTypes()->getPlayersOnField() != null) {
                        $competition->setPlayersOnField($competition->getSportTypes()->getPlayersOnField());
                    } else {
                        $competition->setPlayersOnField($data['playersOnField']);
                    }

                    // If formula is classement and knockout
                    if($formula == 'beide') {
                        $competition->setGroups($data['numGroups']);
                        $competition->setGoeson($data['goingThrough']);
                    } else {
                        $competition->setGroups(null);
                        $competition->setGoeson(null);
                    }

                    $this->get('session')->set('competition', $competition);

                    return $this->redirect($this->generateUrl('competition_maker_location'));
                }
            }

        }

        return $this->render('MatchTrackerAppBundle:CompetitionMaker:formula.html.twig', array('form' => $form->createView(), 'formula' => $formula ));
    }


    /**
     * Competition maker step4: choose location
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function locationAction(Request $request) {
        // Redirect if there's no competition in session
        $competition = $this->get('session')->get('competition');
        if ($competition === null) {
            return $this->redirect($this->generateUrl('competition_maker'));
        }

        // Form constraints
        $constraint = new Assert\Collection(array(
            'field' => array(
                new Assert\NotBlank(array('message' => 'Gelieve aantal velden in te vullen')),
                new Assert\Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen'))),
            'place' => new Assert\NotBlank(array('message' => 'Gelieve een plaats in te vullen')),
            'location' => new Assert\NotBlank(array('message' => 'Gelieve een locatie in te geven'))
        ));

        // Create form with constraints
        $form = $this->createFormBuilder(null, array('validation_constraint' => $constraint))
            ->add('location', 'choice', array('choices' => array('one' => 'Eén locatie', 'more' => 'Elke ploeg eigen terrein'),'label' => 'Locatie', 'attr' => array("onchange" => 'Javascript:locationFunction();')))
            ->add('field', 'integer', array('label' => 'Aantal velden', 'attr' => array()))
            ->add('place', 'text', array('label' => 'Adres'))
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();

            if ($form->isValid()) {

                if ($data['location'] === 'one') {
                    $competition->setFields($data['field']);
                    $competition->setPlace($data['place']);
                } else {
                    $competition->setFields(null);
                    $competition->setPlace(null);
                }

                $sportType = ($this->getDoctrine()
                    ->getRepository('MatchTrackerAppBundle:SportTypes')->findOneByName($competition->getSportTypes()->getName()));
                $competition->setSportTypes($sportType);

                $competition->setUser($this->container->get('security.context')->getToken()->getUser());

                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getManager();
                $em->persist($competition);
                $em->flush();

                return $this->redirect($this->generateUrl('mycompetitions'));

            }

        }

        return $this->render('MatchTrackerAppBundle:CompetitionMaker:location.html.twig', array(
            "form" => $form->createView()));
    }

}
