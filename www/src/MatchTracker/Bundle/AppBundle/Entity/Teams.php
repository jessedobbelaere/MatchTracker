<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teams
 *
 * @ORM\Table(name="teams")
 * @ORM\Entity
 */
class Teams
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_canonical", type="string", length=100, nullable=true)
     */
    private $nameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="gameday", type="string", length=45, nullable=true)
     */
    private $gameday;

    /**
     * @var string
     *
     * @ORM\Column(name="gamehour", type="string", length=45, nullable=true)
     */
    private $gamehour;

    /**
     * @var string
     *
     * @ORM\Column(name="gameplace", type="string", length=255, nullable=true)
     */
    private $gameplace;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=70, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45, nullable=true)
     */
    private $code;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Leagues", mappedBy="teams")
     */
    private $leagues;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Standings", mappedBy="teams")
     */
    private $standings;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Teams
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameCanonical
     *
     * @param string $nameCanonical
     * @return Teams
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = $nameCanonical;
    
        return $this;
    }

    /**
     * Get nameCanonical
     *
     * @return string 
     */
    public function getNameCanonical()
    {
        return $this->nameCanonical;
    }

    /**
     * Set gameday
     *
     * @param string $gameday
     * @return Teams
     */
    public function setGameday($gameday)
    {
        $this->gameday = $gameday;
    
        return $this;
    }

    /**
     * Get gameday
     *
     * @return string 
     */
    public function getGameday()
    {
        return $this->gameday;
    }

    /**
     * Set gamehour
     *
     * @param string $gamehour
     * @return Teams
     */
    public function setGamehour($gamehour)
    {
        $this->gamehour = $gamehour;
    
        return $this;
    }

    /**
     * Get gamehour
     *
     * @return string 
     */
    public function getGamehour()
    {
        return $this->gamehour;
    }

    /**
     * Set gameplace
     *
     * @param string $gameplace
     * @return Teams
     */
    public function setGameplace($gameplace)
    {
        $this->gameplace = $gameplace;
    
        return $this;
    }

    /**
     * Get gameplace
     *
     * @return string 
     */
    public function getGameplace()
    {
        return $this->gameplace;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Teams
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Teams
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add leagues
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues
     * @return Teams
     */
    public function addLeague(\MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues)
    {
        $this->leagues[] = $leagues;
    
        return $this;
    }

    /**
     * Remove leagues
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues
     */
    public function removeLeague(\MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues)
    {
        $this->leagues->removeElement($leagues);
    }

    /**
     * Get leagues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLeagues()
    {
        return $this->leagues;
    }

    /**
     * Add standings
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Standings $standings
     * @return Teams
     */
    public function addStanding(\MatchTracker\Bundle\AppBundle\Entity\Standings $standings)
    {
        $this->standings[] = $standings;
    
        return $this;
    }

    /**
     * Remove standings
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Standings $standings
     */
    public function removeStanding(\MatchTracker\Bundle\AppBundle\Entity\Standings $standings)
    {
        $this->standings->removeElement($standings);
    }

    /**
     * Get standings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStandings()
    {
        return $this->standings;
    }


	/**
	 * Constructor
	 */
	public function __construct($name = null)
	{
		$this->leagues = new \Doctrine\Common\Collections\ArrayCollection();
		$this->standings = new \Doctrine\Common\Collections\ArrayCollection();

		$this->code = substr(md5(uniqid(rand(), true)), 0, 20);
		if($name != null) {
			$this->nameCanonical = \MatchTracker\Bundle\AppBundle\Utils\Utils::canonicalize($name);
		}
	}

	/**
	 * Generate new canonical name
	 */
	public function generateNameCanonical() {
		$this->nameCanonical = \MatchTracker\Bundle\AppBundle\Utils\Utils::canonicalize($this->name);
	}
}