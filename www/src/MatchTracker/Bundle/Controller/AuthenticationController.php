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


class AuthenticationController extends Controller{

    public function loginAction() {

        return $this->render('MatchTrackerBundle:Authentication:login.html.twig');
    }

}
