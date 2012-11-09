<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\Bundle\AppBundle\Entity\Matches
 *
 * @ORM\Table(name="matches")
 * @ORM\Entity
 */
class Matches
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
     * @var \DateTime $date
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime $startTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     */
    private $startTime;

    /**
     * @var Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="home_team", referencedColumnName="id")
     * })
     */
    private $homeTeam;

    /**
     * @var Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="away_team", referencedColumnName="id")
     * })
     */
    private $awayTeam;

    /**
     * @var Leagues
     *
     * @ORM\ManyToOne(targetEntity="Leagues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="leagues_id", referencedColumnName="id")
     * })
     */
    private $leagues;



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
     * Set homeTeam
     *
     * @param MatchTracker\Bundle\AppBundle\Entity\Teams $homeTeam
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
     * @return MatchTracker\Bundle\AppBundle\Entity\Teams
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param MatchTracker\Bundle\AppBundle\Entity\Teams $awayTeam
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
     * @return MatchTracker\Bundle\AppBundle\Entity\Teams
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set leagues
     *
     * @param MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues
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
     * @return MatchTracker\Bundle\AppBundle\Entity\Leagues
     */
    public function getLeagues()
    {
        return $this->leagues;
    }
}