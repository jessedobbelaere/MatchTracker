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


class AuthenticationController extends Controller{

	/**
	 * Go to the login page
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function loginAction() {

		// Check for errors (redirect if so)
	    if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
		    $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	    } else {
		    $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
	    }

		// Create the login form
		$form = $this->createFormBuilder()
			-> add('e-mail', 'email')
			-> add('password', 'password')
			->getForm();

		// Render the login page
        return $this->render('MatchTrackerBundle:Authentication:login.html.twig', array(
	        'form' => $form->createView(),
	        'error' => $error
        ));
    }


    public function registerAction() {

        return $this->render('MatchTrackerBundle:Authentication:register.html.twig');
    }

}
