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


class AuthenticationController extends Controller{

	/**
	 * Show the login page
	 * Useful link: http://www.dobervich.com/2011/03/21/symfony2-blog-application-tutorial-part-v-intro-to-security/
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function loginAction() {

		// Check for errors (redirect if so)
	    if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
		    $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	    }
	    else {
		    $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
	    }

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

	public function login_checkAction() {
		// Will be intercepted
	}


    public function registerAction(Request $request) {

        $errors = array();

        // Create the form
        $form = $this->createFormBuilder()
            -> add('Gebruikersnaam', 'text')
            -> add('E-mail', 'email')
            -> add('Wachtwoord', 'password')
            ->getForm();


        if ($request->isMethod('POST')) {
            $form->bind($request);

            $data = $form->getData(); // data is the array with "name", "mail", "password"

            if ($form->isValid()) {
                $ok = true;
                $user = new \MatchTracker\Bundle\Entity\Users();

                // check
                if (($user->getName($data["Gebruikersnaam"]) !== '' )){
                    $errors[] = "Er bestaat al een gebruiker met deze gebruikersnaam";
                    $ok = false;
                }
                if ($user->getEmail($data["E-mail"]) !== '' ){
                    $errors[] = "Er bestaat al een gebruiker met dit e-mailadres";
                    $ok = false;
                }

                if ($ok){
                    // add to database
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
        }


        // Render the page & assign the form
        return $this->render('MatchTrackerBundle:Authentication:register.html.twig', array(
            "form" => $form->createView(),
            "errors" => $errors
        ));
    }

}
