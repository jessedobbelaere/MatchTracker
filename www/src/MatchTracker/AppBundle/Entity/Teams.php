<?php

namespace MatchTracker\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\AppBundle\Entity\Teams
 *
 * @ORM\Table(name="teams")
 * @ORM\Entity
 */
class Teams
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
     * @var integer $teamusersIdteamusers
     *
     * @ORM\Column(name="teamusers_idteamusers", type="integer", nullable=false)
     */
    private $teamusersIdteamusers;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Leagues", mappedBy="teams")
     */
    private $leagues;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     * })
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->leagues = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Teams
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
     * Set teamusersIdteamusers
     *
     * @param integer $teamusersIdteamusers
     * @return Teams
     */
    public function setTeamusersIdteamusers($teamusersIdteamusers)
    {
        $this->teamusersIdteamusers = $teamusersIdteamusers;
    
        return $this;
    }

    /**
     * Get teamusersIdteamusers
     *
     * @return integer 
     */
    public function getTeamusersIdteamusers()
    {
        return $this->teamusersIdteamusers;
    }

    /**
     * Add leagues
     *
     * @param MatchTracker\AppBundle\Entity\Leagues $leagues
     * @return Teams
     */
    public function addLeague(\MatchTracker\AppBundle\Entity\Leagues $leagues)
    {
        $this->leagues[] = $leagues;
    
        return $this;
    }

    /**
     * Remove leagues
     *
     * @param MatchTracker\AppBundle\Entity\Leagues $leagues
     */
    public function removeLeague(\MatchTracker\AppBundle\Entity\Leagues $leagues)
    {
        $this->leagues->removeElement($leagues);
    }

    /**
     * Get leagues
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLeagues()
    {
        return $this->leagues;
    }

    /**
     * Set users
     *
     * @param MatchTracker\AppBundle\Entity\Users $users
     * @return Teams
     */
    public function setUsers(\MatchTracker\AppBundle\Entity\Users $users = null)
    {
        $this->users = $users;
    
        return $this;
    }

    /**
     * Get users
     *
     * @return MatchTracker\AppBundle\Entity\Users 
     */
    public function getUsers()
    {
        return $this->users;
    }
}