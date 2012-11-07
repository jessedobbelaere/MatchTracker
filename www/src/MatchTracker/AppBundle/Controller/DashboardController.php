<?php

namespace MatchTracker\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

use Doctrine\ORM\EntityRepository;

class DashboardController extends Controller {

    public function indexAction() {


        if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            // user is authenticated
        }
        else{
            return $this->redirect($this->generateUrl('authentication_login'));
        }


        // fetch the competitions related to the user


        $user = null;
        return $this->render('MatchTrackerAppBundle:Dashboard:index.html.twig',
            array('users' => $user)
        );

    }



    public function settingsAction(){
        return $this->render('MatchTrackerAppBundle:Dashboard:profile.html.twig');
    }
	
	



}
