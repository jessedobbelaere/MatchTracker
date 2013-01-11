<?php

namespace MatchTracker\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchesHasMatchEvents
 *
 * @ORM\Table(name="matches_has_match_events")
 * @ORM\Entity
 */
class MatchesHasMatchEvents
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
     * @var integer
     *
     * @ORM\Column(name="time", type="integer", nullable=true)
     */
    private $time;

    /**
     * @var \Matches
     *
     * @ORM\ManyToOne(targetEntity="Matches")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matches_id", referencedColumnName="id")
     * })
     */
    private $matches;

    /**
     * @var \MatchEvents
     *
     * @ORM\ManyToOne(targetEntity="MatchEvents")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="match_events_id", referencedColumnName="id")
     * })
     */
    private $matchEvents;

    /**
     * @var \Players
     *
     * @ORM\ManyToOne(targetEntity="Players")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="players_id", referencedColumnName="id")
     * })
     */
    private $players;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set time
     *
     * @param integer $time
     * @return MatchesHasMatchEvents
     */
    public function setTime($time)
    {
        $this->time = $time;
    
        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set matches
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Matches $matches
     * @return MatchesHasMatchEvents
     */
    public function setMatches(\MatchTracker\Bundle\AppBundle\Entity\Matches $matches = null)
    {
        $this->matches = $matches;
    
        return $this;
    }

    /**
     * Get matches
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Matches 
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * Set matchEvents
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\MatchEvents $matchEvents
     * @return MatchesHasMatchEvents
     */
    public function setMatchEvents(\MatchTracker\Bundle\AppBundle\Entity\MatchEvents $matchEvents = null)
    {
        $this->matchEvents = $matchEvents;
    
        return $this;
    }

    /**
     * Get matchEvents
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\MatchEvents 
     */
    public function getMatchEvents()
    {
        return $this->matchEvents;
    }

    /**
     * Set players
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Players $players
     * @return MatchesHasMatchEvents
     */
    public function setPlayers(\MatchTracker\Bundle\AppBundle\Entity\Players $players = null)
    {
        $this->players = $players;
    
        return $this;
    }

    /**
     * Get players
     *
     * @return \MatchTracker\Bundle\AppBundle\Entity\Players 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set teams
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Teams $teams
     * @return MatchesHasMatchEvents
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