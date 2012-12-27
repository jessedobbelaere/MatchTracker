<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Standings
 *
 * @ORM\Table(name="standings")
 * @ORM\Entity
 */
class Standings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idstandings", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idstandings;

    /**
     * @var string
     *
     * @ORM\Column(name="wins", type="string", length=45, nullable=true)
     */
    private $wins;

    /**
     * @var string
     *
     * @ORM\Column(name="draws", type="string", length=45, nullable=true)
     */
    private $draws;

    /**
     * @var string
     *
     * @ORM\Column(name="losses", type="string", length=45, nullable=true)
     */
    private $losses;

    /**
     * @var string
     *
     * @ORM\Column(name="points", type="string", length=45, nullable=true)
     */
    private $points;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Leagues", mappedBy="standingsstandings")
     */
    private $leagues;

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
        $this->leagues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Get idstandings
     *
     * @return integer 
     */
    public function getIdstandings()
    {
        return $this->idstandings;
    }

    /**
     * Set wins
     *
     * @param string $wins
     * @return Standings
     */
    public function setWins($wins)
    {
        $this->wins = $wins;
    
        return $this;
    }

    /**
     * Get wins
     *
     * @return string 
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Set draws
     *
     * @param string $draws
     * @return Standings
     */
    public function setDraws($draws)
    {
        $this->draws = $draws;
    
        return $this;
    }

    /**
     * Get draws
     *
     * @return string 
     */
    public function getDraws()
    {
        return $this->draws;
    }

    /**
     * Set losses
     *
     * @param string $losses
     * @return Standings
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;
    
        return $this;
    }

    /**
     * Get losses
     *
     * @return string 
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * Set points
     *
     * @param string $points
     * @return Standings
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return string 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Add leagues
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Leagues $leagues
     * @return Standings
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
     * Set teams
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $teams
     * @return Standings
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