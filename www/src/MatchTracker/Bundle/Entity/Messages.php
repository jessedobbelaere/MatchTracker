<?php

namespace MatchTracker\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatchTracker\Bundle\Entity\Messages
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity
 */
class Messages
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
     * @var string $text
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     * })
     */
    private $receiver;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     * })
     */
    private $sender;



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
     * Set text
     *
     * @param string $text
     * @return Messages
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set receiver
     *
     * @param MatchTracker\Bundle\Entity\Users $receiver
     * @return Messages
     */
    public function setReceiver(\MatchTracker\Bundle\Entity\Users $receiver = null)
    {
        $this->receiver = $receiver;
    
        return $this;
    }

    /**
     * Get receiver
     *
     * @return MatchTracker\Bundle\Entity\Users 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set sender
     *
     * @param MatchTracker\Bundle\Entity\Users $sender
     * @return Messages
     */
    public function setSender(\MatchTracker\Bundle\Entity\Users $sender = null)
    {
        $this->sender = $sender;
    
        return $this;
    }

    /**
     * Get sender
     *
     * @return MatchTracker\Bundle\Entity\Users 
     */
    public function getSender()
    {
        return $this->sender;
    }
}