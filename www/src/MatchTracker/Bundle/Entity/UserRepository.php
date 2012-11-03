<?php

namespace MatchTracker\Bundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * With this custom UserRepository we will allow login by username OR e-mail
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{

	/**
	 * Check username OR email when logging in
	 *
	 * @param string $username
	 * @return mixed|\Symfony\Component\Security\Core\User\UserInterface
	 */
	public function loadUserByUsername($username) {
		return $this->getEntityManager()
			->createQuery('SELECT u FROM MatchTracker\Bundle\Entity\Users u
         WHERE u.username = :username
         OR u.email = :username')
			->setParameters(array(
			'username' => $username
		))
			->getOneOrNullResult();
	}

	/**
	 * Refresh the user
	 *
	 * @param \Symfony\Component\Security\Core\User\UserInterface $user
	 * @return mixed|\Symfony\Component\Security\Core\User\UserInterface
	 */
	public function refreshUser(UserInterface $user) {
		return $this->loadUserByUsername($user->getUsername());
	}

	/**
	 * Supports class implementation
	 *
	 * @param string $class
	 * @return bool
	 */
	public function supportsClass($class) {
		return $class === 'MatchTracker\Bundle\Entity\Users';
	}
}
