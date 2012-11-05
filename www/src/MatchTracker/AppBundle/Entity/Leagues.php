<?php

namespace MatchTracker\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\AppBundle\Entity\Leagues
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
     * @var integer $fields
     *
     * @ORM\Column(name="fields", type="integer", nullable=true)
     */
    private $fields;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer $numberOfTeams
     *
     * @ORM\Column(name="number_of_teams", type="integer", nullable=true)
     */
    private $numberOfTeams;

    /**
     * @var \DateTime $startdate
     *
     * @ORM\Column(name="startdate", type="date", nullable=true)
     */
    private $startdate;

    /**
     * @var \DateTime $enddate
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @var integer $playersOnField
     *
     * @ORM\Column(name="players_on_field", type="integer", nullable=true)
     */
    private $playersOnField;

    /**
     * @var string $place
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
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
     * @var SportTypes
     *
     * @ORM\ManyToOne(targetEntity="SportTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_types_id", referencedColumnName="id")
     * })
     */
    private $sportTypes;

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
     * Set fields
     *
     * @param integer $fields
     * @return Leagues
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    
        return $this;
    }

    /**
     * Get fields
     *
     * @return integer 
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Leagues
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set numberOfTeams
     *
     * @param integer $numberOfTeams
     * @return Leagues
     */
    public function setNumberOfTeams($numberOfTeams)
    {
        $this->numberOfTeams = $numberOfTeams;
    
        return $this;
    }

    /**
     * Get numberOfTeams
     *
     * @return integer 
     */
    public function getNumberOfTeams()
    {
        return $this->numberOfTeams;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     * @return Leagues
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    
        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime 
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     * @return Leagues
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    
        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime 
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set playersOnField
     *
     * @param integer $playersOnField
     * @return Leagues
     */
    public function setPlayersOnField($playersOnField)
    {
        $this->playersOnField = $playersOnField;
    
        return $this;
    }

    /**
     * Get playersOnField
     *
     * @return integer 
     */
    public function getPlayersOnField()
    {
        return $this->playersOnField;
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
     * @param MatchTracker\AppBundle\Entity\Teams $teams
     * @return Leagues
     */
    public function addTeam(\MatchTracker\AppBundle\Entity\Teams $teams)
    {
        $this->teams[] = $teams;
    
        return $this;
    }

    /**
     * Remove teams
     *
     * @param MatchTracker\AppBundle\Entity\Teams $teams
     */
    public function removeTeam(\MatchTracker\AppBundle\Entity\Teams $teams)
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
     * @param MatchTracker\AppBundle\Entity\Users $user
     * @return Leagues
     */
    public function setUser(\MatchTracker\AppBundle\Entity\Users $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return MatchTracker\AppBundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set sportTypes
     *
     * @param MatchTracker\AppBundle\Entity\SportTypes $sportTypes
     * @return Leagues
     */
    public function setSportTypes(\MatchTracker\AppBundle\Entity\SportTypes $sportTypes = null)
    {
        $this->sportTypes = $sportTypes;
    
        return $this;
    }

    /**
     * Get sportTypes
     *
     * @return MatchTracker\AppBundle\Entity\SportTypes 
     */
    public function getSportTypes()
    {
        return $this->sportTypes;
    }
}