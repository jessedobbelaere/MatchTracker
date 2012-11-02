<?php
/**
 * Created by JetBrains PhpStorm.
 * User: stephane
 * Date: 1/11/12
 * Time: 00:07
 * To change this template use File | Settings | File Templates.
 */


namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\Request;

//use Symfony\Component\Validator\Constraints\Email;
//use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;


class AuthenticationController extends Controller{

	/**
	 * Show the login page
	 *
	 * @
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function loginAction() {

		// Check for errors
	    if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
		    $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	    }
	    else {
		    $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
	    }


		// TODO: use _name with form
		// Create the login form
//		$form = $this->createFormBuilder()
//			-> add('e-mail', 'email')
//			-> add('password', 'password')
//			->getForm();

		// Render the login page
        return $this->render('MatchTrackerBundle:Authentication:login.html.twig', array(
	        'error' => $error
        ));
    }

	/**
	 * The register action
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function registerAction(Request $request) {

        $errors = array();

        $collectionConstraint = new Assert\Collection(array(
            'Gebruikersnaam'    => array(new Assert\NotBlank(array('message' => 'Gelieve een gebruikersnaam op te geven'))),
            'E-mail'            => array(new Assert\NotBlank(array('message' => 'Gelieve een e-mailadres op te geven')),
                                         new Assert\Email(array('message' => 'Gelieve een geldig e-mailadres op te geven'))),
            'Wachtwoord'        => new Assert\NotBlank(array('message' => 'Gelieve een wachtwoord op te geven')),
        ));


        // Create the form
        $form = $this->createFormBuilder(null, array('validation_constraint' => $collectionConstraint))
            -> add('Gebruikersnaam', 'text')
            -> add('E-mail', 'email')
            -> add('Wachtwoord', 'password')
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->bind($request);

            $data = $form->getData(); // data is the array with "name", "mail", "password"

            $userDoc = $this->getDoctrine()
                ->getRepository('MatchTrackerBundle:Users');

            // Check if username is unique
            if ($userDoc->findOneBy(array('name' => $data['Gebruikersnaam'])) !== null){
                $form->get('Gebruikersnaam')->addError(new FormError('Er bestaat al een gebruiker met deze naam'));
            }

            // Check if e-mail is unique
            if ($userDoc->findOneBy(array('email' => $data['E-mail'])) !== null){
                $form->get('E-mail')->addError(new FormError('Er bestaat al een e-mail met deze naam'));
            }

                if ($form->isValid()) {
                    $user = new \MatchTracker\Bundle\Entity\Users();

                    $user->setName($data["Gebruikersnaam"]);
                    $user->setEmail($data["E-mail"]);
                    $user->setPassword(md5($data["Wachtwoord"]));

                    //fetches Doctrine's entity manager object, which is responsible for handling the process of persisting
                    //and fetching objects to and from the database;
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush(); //executes an insert
            }
        }


        // Render the page & assign the form
        return $this->render('MatchTrackerBundle:Authentication:register.html.twig', array(
            "form" => $form->createView(),
        ));
    }

}
