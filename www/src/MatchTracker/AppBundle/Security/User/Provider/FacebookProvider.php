<?php

namespace MatchTracker\AppBundle\Security\User\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use \BaseFacebook;
use \FacebookApiException;

class FacebookProvider implements UserProviderInterface
{
	/**
	 * @var \Facebook
	 */
	protected $facebook;
	protected $userManager;
	protected $validator;

	public function __construct(BaseFacebook $facebook, $userManager, $validator)
	{
		$this->facebook = $facebook;
		$this->userManager = $userManager;
		$this->validator = $validator;
	}

	public function supportsClass($class)
	{
		return $this->userManager->supportsClass($class);
	}

	public function findUserByFbId($fbId)
	{
		$user = $this->userManager->findUserBy(array('facebookId' => $fbId));
		return $user;
	}

	public function loadUserByUsername($username)
	{
		// Try to find a user in the db with fbId already set
		$user = $this->findUserByFbId($username);

		// pull the facebook data
		try {
			$fbdata = $this->facebook->api('/me');
		} catch (FacebookApiException $e) {
			$fbdata = null;
		}

		if (!empty($fbdata)) {

			// No user with fbid was found in the db
			if (empty($user)) {

				// Search user in db by email?
				$userByMail = $this->userManager->findUserByEmail($fbdata['email']);

				if(!empty($userByMail)) {
					$user = $userByMail;

					// Set the facebookId from this user
					$user->setFacebookId($username);
				} else {

					// We couldn't find a user, let's make one!
					$user = $this->userManager->createUser();
					$user->setEnabled(true);
					$user->setPassword('');
					$user->setUsername($username);
					$user->setFacebookId($username);
				}
			}


			// Add missing information
			// TODO use http://developers.facebook.com/docs/api/realtime
			$user->setFBData($fbdata);

			if (count($this->validator->validate($user, 'Facebook'))) {
				// TODO: the user was found obviously, but doesnt match our expectations, do something smart
				throw new UsernameNotFoundException('The facebook user could not be stored');
			}
			$this->userManager->updateUser($user);
		}

		if (empty($user)) {
			throw new UsernameNotFoundException('The user is not authenticated on facebook');
		}

		return $user;
	}

	public function refreshUser(UserInterface $user)
	{
		if (!$this->supportsClass(get_class($user)) || !$user->getFacebookId()) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
		}

		return $this->loadUserByUsername($user->getFacebookId());
	}
}