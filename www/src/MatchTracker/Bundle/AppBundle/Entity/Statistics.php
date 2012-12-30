<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistics
 *
 * @ORM\Table(name="statistics")
 * @ORM\Entity
 */
class Statistics
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idstatistics", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idstatistics;

    /**
     * @var integer
     *
     * @ORM\Column(name="wins", type="integer", nullable=true)
     */
    private $wins;

    /**
     * @var integer
     *
     * @ORM\Column(name="draws", type="integer", nullable=true)
     */
    private $draws;

    /**
     * @var integer
     *
     * @ORM\Column(name="losses", type="integer", nullable=true)
     */
    private $losses;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Standings", mappedBy="statistics")
     */
    private $standings;

    /**
     * @var \Teams
     *
     * @ORM\ManyToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="teams_id", referencedColumnName="id")
     * })
     */
    private $teams;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->standings = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Get idstatistics
     *
     * @return integer 
     */
    public function getIdstatistics()
    {
        return $this->idstatistics;
    }

    /**
     * Set wins
     *
     * @param integer $wins
     * @return Statistics
     */
    public function setWins($wins)
    {
        $this->wins = $wins;
    
        return $this;
    }

    /**
     * Get wins
     *
     * @return integer 
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Set draws
     *
     * @param integer $draws
     * @return Statistics
     */
    public function setDraws($draws)
    {
        $this->draws = $draws;
    
        return $this;
    }

    /**
     * Get draws
     *
     * @return integer 
     */
    public function getDraws()
    {
        return $this->draws;
    }

    /**
     * Set losses
     *
     * @param integer $losses
     * @return Statistics
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;
    
        return $this;
    }

    /**
     * Get losses
     *
     * @return integer 
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Statistics
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Statistics
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add standings
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Standings $standings
     * @return Statistics
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
     * Set teams
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $teams
     * @return Statistics
     */
    public function setTeams(\MatchTracker\Bundle\AppBundle\Entity\Teams $teams = null)
    {
        $this->teams = $teams;
    
        return $this;
    }

    /**
     * Get teams
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Teams 
     */
    public function getTeams()
    {
        return $this->teams;
    }


}


