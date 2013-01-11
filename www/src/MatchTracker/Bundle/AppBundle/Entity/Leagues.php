<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leagues
 *
 * @ORM\Table(name="leagues")
 * @ORM\Entity
 */
class Leagues
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
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_canonical", type="string", length=45, nullable=true)
     */
    private $nameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_teams", type="integer", nullable=true)
     */
    private $numberOfTeams;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date", nullable=true)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    private $enddate;

    /**
     * @var integer
     *
     * @ORM\Column(name="players_on_field", type="integer", nullable=true)
     */
    private $playersOnField;

    /**
     * @var integer
     *
     * @ORM\Column(name="fields", type="integer", nullable=true)
     */
    private $fields;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @var boolean
     *
     * @ORM\Column(name="return_match", type="boolean", nullable=true)
     */
    private $returnMatch;

    /**
     * @var integer
     *
     * @ORM\Column(name="groups", type="integer", nullable=true)
     */
    private $groups;

    /**
     * @var integer
     *
     * @ORM\Column(name="goesOn", type="integer", nullable=true)
     */
    private $goeson;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Standings", mappedBy="leagues")
     */
    private $standings;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Teams", inversedBy="leagues", cascade={"all"})
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
     * @var \SportTypes
     *
     * @ORM\ManyToOne(targetEntity="SportTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_types_id", referencedColumnName="id")
     * })
     */
    private $sportTypes;

    /**
     * @var \Users
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
        $this->standings = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Leagues
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
     * Set returnMatch
     *
     * @param boolean $returnMatch
     * @return Leagues
     */
    public function setReturnMatch($returnMatch)
    {
        $this->returnMatch = $returnMatch;
    
        return $this;
    }

    /**
     * Get returnMatch
     *
     * @return boolean 
     */
    public function getReturnMatch()
    {
        return $this->returnMatch;
    }

    /**
     * Set groups
     *
     * @param integer $groups
     * @return Leagues
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    
        return $this;
    }

    /**
     * Get groups
     *
     * @return integer 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set goeson
     *
     * @param integer $goeson
     * @return Leagues
     */
    public function setGoeson($goeson)
    {
        $this->goeson = $goeson;
    
        return $this;
    }

    /**
     * Get goeson
     *
     * @return integer 
     */
    public function getGoeson()
    {
        return $this->goeson;
    }

    /**
     * Add standings
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Standings $standings
     * @return Leagues
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
     * Add teams
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $teams
     * @return Leagues
     */
    public function addTeam(\MatchTracker\Bundle\AppBundle\Entity\Teams $teams)
    {
        $this->teams[] = $teams;
    
        return $this;
    }

    /**
     * Remove teams
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $teams
     */
    public function removeTeam(\MatchTracker\Bundle\AppBundle\Entity\Teams $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Set sportTypes
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\SportTypes $sportTypes
     * @return Leagues
     */
    public function setSportTypes(\MatchTracker\Bundle\AppBundle\Entity\SportTypes $sportTypes = null)
    {
        $this->sportTypes = $sportTypes;
    
        return $this;
    }

    /**
     * Get sportTypes
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\SportTypes 
     */
    public function getSportTypes()
    {
        return $this->sportTypes;
    }

    /**
     * Set user
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Users $user
     * @return Leagues
     */
    public function setUser(\MatchTracker\Bundle\AppBundle\Entity\Users $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Generate new canonical name
     */
    public function generateNameCanonical() {
        $this->nameCanonical = \MatchTracker\Bundle\AppBundle\Utils\Utils::canonicalize($this->name);
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
        $this->generateNameCanonical();

        return $this;
    }


}