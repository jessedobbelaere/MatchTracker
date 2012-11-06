<?php

namespace MatchTracker\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

use Doctrine\ORM\EntityRepository;

class DashboardController extends Controller {

    public function indexAction() {

        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session */
        $foo = $session->get('foo');

        // get the error if any (works with forward and redirect -- see below)
        if ($session === null){
            HttpResponse::redirect('authentication_login');
        }

        $user = null;
        return $this->render('MatchTrackerAppBundle:Dashboard:index.html.twig',
            array('users' => $user)
        );
    }
	
	



}
