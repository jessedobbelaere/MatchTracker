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
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="statistics_id", type="integer", nullable=true)
     */
    private $statisticsId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Leagues", inversedBy="standings")
     * @ORM\JoinTable(name="leagues_has_standings",
     *   joinColumns={
     *     @ORM\JoinColumn(name="standings_id", referencedColumnName="idstandings")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="leagues_id", referencedColumnName="id")
     *   }
     * )
     */
    private $leagues;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Statistics", inversedBy="standings")
     * @ORM\JoinTable(name="standings_has_statistics",
     *   joinColumns={
     *     @ORM\JoinColumn(name="standings_id", referencedColumnName="idstandings")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="statistics_id", referencedColumnName="idstatistics")
     *   }
     * )
     */
    private $statistics;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->leagues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->statistics = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Standings
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
     * Set statisticsId
     *
     * @param integer $statisticsId
     * @return Standings
     */
    public function setStatisticsId($statisticsId)
    {
        $this->statisticsId = $statisticsId;
    
        return $this;
    }

    /**
     * Get statisticsId
     *
     * @return integer 
     */
    public function getStatisticsId()
    {
        return $this->statisticsId;
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
     * Add statistics
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Statistics $statistics
     * @return Standings
     */
    public function addStatistic(\MatchTracker\Bundle\AppBundle\Entity\Statistics $statistics)
    {
        $this->statistics[] = $statistics;
    
        return $this;
    }

    /**
     * Remove statistics
     *
     * @param \MatchTracker\Bundle\AppBundle\Entity\Statistics $statistics
     */
    public function removeStatistic(\MatchTracker\Bundle\AppBundle\Entity\Statistics $statistics)
    {
        $this->statistics->removeElement($statistics);
    }

    /**
     * Get statistics
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStatistics()
    {
        return $this->statistics;
    }


    /**
     * Get the sorted statistics
     *
     * @return array
     */
    public function getSortedStatistics(){

        $statistics = $this->statistics->toArray();;
        usort($statistics,array($this,'cmpPositions'));

        return $statistics;

    }


    /**
     * Compare the positions
     *
     * @param $a
     * @param $b
     * @return int
     */
    function cmpPositions($a, $b)
    {
        if ($a->getPosition() > $b->getPosition()) return 1;
        if ($a->getPosition() < $b->getPosition()) return -1;
        return 0;
    }

}