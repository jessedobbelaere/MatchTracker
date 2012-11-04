<?php

namespace MatchTracker\Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testIndex()
	{
		// Create client
		$client = static::createClient();
		//$client->followRedirect();

		// Request the secured page with invalid credentials
		//$crawler = $client->request('GET', '/dashboard/', array(), array(),
			//array('PHP_AUTH_USER' => 'jesse', 'PHP_AUTH_PW' => 'wrong_pass'));

		//$this->assertEquals(200, $client->getResponse()->getStatusCode());

		// we should be redirected to the login page
		//$this->assertTrue($crawler->filter('title:contains("Login")')->count() > 0);

		// request the index action with valid credentials
		$crawler = $client->request('GET', '/dashboard/', array(), array(),
			array('PHP_AUTH_USER' => 'jesse', 'PHP_AUTH_PW' => 'jesse'));

		$this->assertEquals(200, $client->getResponse()->getStatusCode());

		// check the title of the page matches the dashboard home page
		$this->assertTrue($crawler->filter('title:contains("MatchTracker - Dashboard")')->count() > 0);

		// check that the logout link exists
		$this->assertTrue($crawler->filter('a:contains("Log out")')->count() > 0);
	}
}
