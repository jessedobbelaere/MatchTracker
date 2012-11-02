<?php


namespace MatchTracker\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use MatchTracker\Bundle\Entity\Users;


/**
 * Authentication controller used for logging in and to register a new user.
 */
class AuthenticationController extends Controller{

	/**
	 * Show the login form
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function loginAction() {
		// @todo show errors on the login page
		// Check for errors
	    if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
		    $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	    }

		// Render the login page
        return $this->render('MatchTrackerBundle:Authentication:login.html.twig', array(
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


		// If form is submitted
        if ($request->isMethod('POST')) {

	        // Bind the submitted form values to the form object
	        $form->bind($request);

	        // Get the data from the form
            $data = $form->getData(); // data is the array with "name", "mail", "password"

	        // Get the Users doctrine
            $userDoc = $this->getDoctrine()
                            ->getRepository('MatchTrackerBundle:Users');

            // Check if username already exists
            if ($userDoc->findOneBy(array('username' => $data['Gebruikersnaam'])) !== null){
                $form->get('Gebruikersnaam')->addError(new FormError('Er bestaat al een gebruiker met deze naam'));
            }

            // Check if e-mail already exists
            if ($userDoc->findOneBy(array('email' => $data['E-mail'])) !== null){
                $form->get('E-mail')->addError(new FormError('Er bestaat al een e-mail met deze naam'));
            }

	        // Form is valid, register the user and save it in the database
            if ($form->isValid()) {
	            $user = new Users();

                $user->setUsername($data['Gebruikersnaam']);
                $user->setEmail($data['E-mail']);
                $user->setPassword($data['Wachtwoord']);

                // Fetches Doctrine's entity manager object, which is responsible for handling the process of persisting
                // and fetching objects to and from the database;
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush(); // Executes the insert query

	            // Show the registration succesful page
	            return $this->render('MatchTrackerBundle:Authentication:register_success.html.twig');
            }
        }

        // Render the page & assign the form
        return $this->render('MatchTrackerBundle:Authentication:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
