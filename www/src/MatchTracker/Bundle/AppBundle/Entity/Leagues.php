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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="fields", type="integer", nullable=true)
     */
    protected $fields;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_teams", type="integer", nullable=true)
     */
    protected $numberOfTeams;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date", nullable=true)
     */
    protected $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date", nullable=true)
     */
    protected $enddate;

    /**
     * @var integer
     *
     * @ORM\Column(name="players_on_field", type="integer", nullable=true)
     */
    protected $playersOnField;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    protected $place;

    /**
     * @var boolean
     *
     * @ORM\Column(name="return_match", type="boolean", nullable=true)
     */
    protected $return;

    /**
     * @var integer
     *
     * @ORM\Column(name="groups", type="integer", nullable=true)
     */
    protected $groups;

    /**
     * @var integer
     *
     * @ORM\Column(name="goesOn", type="integer", nullable=true)
     */
    protected $goeson;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Standings", inversedBy="leagues")
     * @ORM\JoinTable(name="leagues_has_standings",
     *   joinColumns={
     *     @ORM\JoinColumn(name="leagues_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="standings_idstandings", referencedColumnName="idstandings")
     *   }
     * )
     */
    private $standingsstandings;

    /**
     * @var \Doctrine\Common\Collections\Collection
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
    protected $teams;

    /**
     * @var \SportTypes
     *
     * @ORM\ManyToOne(targetEntity="SportTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_types_id", referencedColumnName="id")
     * })
     */
    protected $sportTypes;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->standingsstandings = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add standingsstandings
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Standings $standingsstandings
     * @return Leagues
     */
    public function addStandingsstanding(\MatchTracker\Bundle\AppBundle\Entity\Standings $standingsstandings)
    {
        $this->standingsstandings[] = $standingsstandings;
    
        return $this;
    }

    /**
     * Remove standingsstandings
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Standings $standingsstandings
     */
    public function removeStandingsstanding(\MatchTracker\Bundle\AppBundle\Entity\Standings $standingsstandings)
    {
        $this->standingsstandings->removeElement($standingsstandings);
    }

    /**
     * Get standingsstandings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStandingsstandings()
    {
        return $this->standingsstandings;
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
     * Set return
     *
     * @param boolean $return
     * @return Leagues
     */
    public function setReturn($return)
    {
        $this->return = $return;
    
        return $this;
    }

    /**
     * Get return
     *
     * @return boolean 
     */
    public function getReturn()
    {
        return $this->return;
    }
}