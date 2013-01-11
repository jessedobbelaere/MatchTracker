<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matches
 *
 * @ORM\Table(name="matches")
 * @ORM\Entity
 */
class Matches
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
     * @var \Date
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var \Time
     *
     * @ORM\Column(name="start_time", type="time", nullable=true)
     */
    private $startTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="home_score", type="integer", nullable=true)
     */
    private $homeScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="away_score", type="integer", nullable=true)
     */
    private $awayScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="finished", type="integer", nullable=true)
     */
    private $finished;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

    /**
     * @var \Leagues
     *
     * @ORM\ManyToOne(targetEntity="Leagues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="leagues_id", referencedColumnName="id")
     * })
     */
    private $leagues;

    /**
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="home_team", referencedColumnName="id")
     * })
     */
    private $homeTeam;

    /**
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="away_team", referencedColumnName="id")
     * })
     */
    private $awayTeam;



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
     * Set date
     *
     * @param \DateTime $date
     * @return Matches
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Matches
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set homeScore
     *
     * @param integer $homeScore
     * @return Matches
     */
    public function setHomeScore($homeScore)
    {
        $this->homeScore = $homeScore;
    
        return $this;
    }

    /**
     * Get homeScore
     *
     * @return integer 
     */
    public function getHomeScore()
    {
        return $this->homeScore;
    }

    /**
     * Set awayScore
     *
     * @param integer $awayScore
     * @return Matches
     */
    public function setAwayScore($awayScore)
    {
        $this->awayScore = $awayScore;
    
        return $this;
    }

    /**
     * Get awayScore
     *
     * @return integer 
     */
    public function getAwayScore()
    {
        return $this->awayScore;
    }

    /**
     * Set finished
     *
     * @param integer $finished
     * @return Matches
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;
    
        return $this;
    }

    /**
     * Get finished
     *
     * @return integer 
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Matches
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set leagues
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues
     * @return Matches
     */
    public function setLeagues(\MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues = null)
    {
        $this->leagues = $leagues;
    
        return $this;
    }

    /**
     * Get leagues
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Leagues 
     */
    public function getLeagues()
    {
        return $this->leagues;
    }

    /**
     * Set homeTeam
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $homeTeam
     * @return Matches
     */
    public function setHomeTeam(\MatchTracker\Bundle\AppBundle\Entity\Teams $homeTeam = null)
    {
        $this->homeTeam = $homeTeam;
    
        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Teams 
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $awayTeam
     * @return Matches
     */
    public function setAwayTeam(\MatchTracker\Bundle\AppBundle\Entity\Teams $awayTeam = null)
    {
        $this->awayTeam = $awayTeam;
    
        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Teams 
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }
}