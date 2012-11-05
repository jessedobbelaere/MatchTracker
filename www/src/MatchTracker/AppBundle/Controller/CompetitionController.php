<?php

namespace MatchTracker\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;

class CompetitionController extends Controller {
	
	public function indexAction($sport) {
		return $this->render('MatchTrackerAppBundle:Competition:index.html.twig', 
				array('sport' => $sport));
	}
	
	
    public function detailAction($name) {
    	
    	$league = $this->getDoctrine()
    	->getRepository('MatchTrackerAppBundle:Leagues')
    	->find($name);
    	
        return $this->render('MatchTrackerAppBundle:Competition:detail.html.twig', 
        		array('league' => $league));
    }

    public function makerAction(Request $request) {
        $constraint = new Assert\Collection(array(
            'name' => new Assert\NotBlank(array('message' => 'Gelieve naam in te vullen')),
            'place' => new Assert\NotBlank(array('message' => 'Gelieve naam in te vullen')),
            'description' => new Assert\NotBlank(array('message' => 'Gelieve beschrijving in te vullen')),
            'sport' => new Assert\NotBlank(array('message' => 'Gelieve een sport aan te duiden'))
        ));

        // Get Sports
        $products = $this->getDoctrine()
            ->getRepository('MatchTrackerAppBundle:Sports')->findAll();

        $productNames = array();

        foreach ($products as $prod) {
            array_push($productNames, $prod->getName());
        }

        $form = $this->createFormBuilder(null, array('validation_constraint' => $constraint))
            -> add('name', 'text', array('label' => 'Naam'))
            -> add('place', 'text', array('label' => 'Plaats'))
            -> add('description', 'textarea', array('label' => 'Beschrijving'))
            ->add('sport', 'choice', array(
            'label' => 'Sport',
            'choices'   => $productNames,
            'empty_value' => 'Kies een sport'))
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();


            if ($form->isValid()) {
                /*
                $competition = new Leagues();
                $competition->setName($data["name"]);
                $competition->setPlace($data["place"]);
                $competition->setDescription($data["description"]);
                $competition->setUser($this->getUser());

                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getManager();
                $em->persist($competition);
                $em->flush();*/

                return $this->redirect($this->generateUrl('competition_maker_details'));
            }

        }

        return $this->render('MatchTrackerAppBundle:Competition:maker.html.twig', array(
            "form" => $form->createView()));
    }
}
