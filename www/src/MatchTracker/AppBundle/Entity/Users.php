<?php

namespace MatchTracker\AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\AppBundle\Entity\Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	public function __construct()
	{
		parent::__construct();
		// your own logic
	}

	/**
	 * @var string
	 *
	 * @ORM\Column(name="firstname", type="string", length=255)
	 */
	protected $firstname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lastname", type="string", length=255)
	 */
	protected $lastname;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="facebookId", type="string", length=255)
	 */
	protected $facebookId;

	/**
	 * @var string $twitterid
	 *
	 * @ORM\Column(name="twitterID", type="string", length=255, nullable=true)
	 */
	private $twitterid;

	/**
	 * @var string $twitterUsername
	 *
	 * @ORM\Column(name="twitter_username", type="string", length=255, nullable=true)
	 */
	private $twitterUsername;




	public function serialize()
	{
		return serialize(array($this->facebookId, parent::serialize()));
	}

	public function unserialize($data)
	{
		list($this->facebookId, $parentData) = unserialize($data);
		parent::unserialize($parentData);
	}

	/**
	 * @return string
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
	}

	/**
	 * @return string
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
	}

	/**
	 * Get the full name of the user (first + last name)
	 * @return string
	 */
	public function getFullName()
	{
		return $this->getFirstName() . ' ' . $this->getLastname();
	}

	/**
	 * @param string $facebookId
	 * @return void
	 */
	public function setFacebookId($facebookId)
	{
		$this->facebookId = $facebookId;
		//$this->setUsername($facebookId);
		//$this->salt = '';
	}

	/**
	 * @return string
	 */
	public function getFacebookId()
	{
		return $this->facebookId;
	}

	/**
	 * Set twitterid
	 *
	 * @param string $twitterid
	 * @return Users
	 */
	public function setTwitterid($twitterid)
	{
		$this->twitterid = $twitterid;

		return $this;
	}

	/**
	 * Get twitterid
	 *
	 * @return string
	 */
	public function getTwitterid()
	{
		return $this->twitterid;
	}

	/**
	 * Set twitterUsername
	 *
	 * @param string $twitterUsername
	 * @return Users
	 */
	public function setTwitterUsername($twitterUsername)
	{
		$this->twitterUsername = $twitterUsername;

		return $this;
	}

	/**
	 * Get twitterUsername
	 *
	 * @return string
	 */
	public function getTwitterUsername()
	{
		return $this->twitterUsername;
	}

	/**
	 * @param Array
	 */
	public function setFBData($fbdata)
	{
/*		if (isset($fbdata['id'])) {
			$this->setFacebookId($fbdata['id']);
			$this->addRole('ROLE_USER');
		}*/
		if (isset($fbdata['first_name'])) {
			$this->setFirstname($fbdata['first_name']);
		}
		if (isset($fbdata['last_name'])) {
			$this->setLastname($fbdata['last_name']);
		}
		if (isset($fbdata['email'])) {
			$this->setEmail($fbdata['email']);
		}
	}
}