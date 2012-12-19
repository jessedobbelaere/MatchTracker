<?php

namespace MatchTracker\Bundle\AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

	    $client = static::createClient(array(), array(
		    'PHP_AUTH_USER' => 'jesse',
		    'PHP_AUTH_PW'   => 'jesse',
	    ));

	    $client->followRedirects();
    }
}
