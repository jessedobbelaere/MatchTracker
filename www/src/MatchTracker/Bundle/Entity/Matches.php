<?php

namespace MatchTracker\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\Bundle\Entity\Matches
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
     * @param MatchTracker\Bundle\Entity\Teams $homeTeam
     * @return Matches
     */
    public function setHomeTeam(\MatchTracker\Bundle\Entity\Teams $homeTeam = null)
    {
        $this->homeTeam = $homeTeam;
    
        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return MatchTracker\Bundle\Entity\Teams 
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param MatchTracker\Bundle\Entity\Teams $awayTeam
     * @return Matches
     */
    public function setAwayTeam(\MatchTracker\Bundle\Entity\Teams $awayTeam = null)
    {
        $this->awayTeam = $awayTeam;
    
        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return MatchTracker\Bundle\Entity\Teams 
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }
}