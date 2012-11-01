<?php

namespace MatchTracker\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\Bundle\Entity\Leagues
 *
 * @ORM\Table(name="leagues")
 * @ORM\Entity
 */
class Leagues
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string $place
     *
     * @ORM\Column(name="place", type="string", length=45, nullable=true)
     */
    private $place;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Teams", inversedBy="leagues")
     * @ORM\JoinTable(name="leagues_has_teams",
     *   joinColumns={
     *     @ORM\JoinColumn(name="leagues_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="teams_id", referencedColumnName="id")
     *   }
     * )
     */
    private $teams;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

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
     * @return Leagues
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
     * Set place
     *
     * @param string $place
     * @return Leagues
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Add teams
     *
     * @param MatchTracker\Bundle\Entity\Teams $teams
     * @return Leagues
     */
    public function addTeam(\MatchTracker\Bundle\Entity\Teams $teams)
    {
        $this->teams[] = $teams;
    
        return $this;
    }

    /**
     * Remove teams
     *
     * @param MatchTracker\Bundle\Entity\Teams $teams
     */
    public function removeTeam(\MatchTracker\Bundle\Entity\Teams $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Set user
     *
     * @param MatchTracker\Bundle\Entity\Users $user
     * @return Leagues
     */
    public function setUser(\MatchTracker\Bundle\Entity\Users $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return MatchTracker\Bundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }
}