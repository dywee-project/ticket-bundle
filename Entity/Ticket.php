<?php

namespace Dywee\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Dywee\TicketBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /** @ORM\Column(name="type", type="string", length=255, nullable=true) */
    private $type;

    /** @ORM\Column(name="createdAt", type="datetime") */
    private $createdAt;

    /** @ORM\Column(name="supportAt", type="datetime", nullable=true) */
    private $supportAt;

    /** @ORM\Column(name="updatedAt", type="datetime") */
    private $updatedAt;

    /** @ORM\Column(name="endedAt", type="datetime", nullable=true) */
    private $endedAt;

    /** @ORM\ManyToOne(targetEntity="UserBundle\Entity\User") */
    private $handledBy;

    /** @ORM\ManyToOne(targetEntity="UserBundle\Entity\User") */
    private $createdBy;

    /** @ORM\OneToMany(targetEntity="TicketMessage", mappedBy="ticket", cascade={"persist", "remove"}) */
    private $ticketMessages;

    /** @ORM\ManyToOne(targetEntity="TicketCategory", inversedBy="tickets") */
    private $category;

    /** @ORM\ManyToOne(targetEntity="TicketState") */
    private $state;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Ticket
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title by alias
     *
     * @param string $subject
     *
     * @return Ticket
     */
    public function setSubject($subject)
    {
        $this->title = $subject;

        return $this;
    }

    /**
     * Get title alias
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->title;
    }
    
    /**
     * Set type
     *
     * @param string $type
     *
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ticket
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set supportAt
     *
     * @param \DateTime $supportAt
     *
     * @return Ticket
     */
    public function setSupportAt($supportAt)
    {
        $this->supportAt = $supportAt;

        return $this;
    }

    /**
     * Get supportAt
     *
     * @return \DateTime
     */
    public function getSupportAt()
    {
        return $this->supportAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Ticket
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set endedAt
     *
     * @param \DateTime $endedAt
     *
     * @return Ticket
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * Get endedAt
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set handledBy
     *
     * @param \UserBundle\Entity\User $handledBy
     *
     * @return Ticket
     */
    public function setHandledBy(\UserBundle\Entity\User $handledBy = null)
    {
        $this->handledBy = $handledBy;

        return $this;
    }

    /**
     * Get handledBy
     *
     * @return \UserBundle\Entity\User
     */
    public function getHandledBy()
    {
        return $this->handledBy;
    }

    /**
     * Set createdBy
     *
     * @param \UserBundle\Entity\User $createdBy
     *
     * @return Ticket
     */
    public function setCreatedBy(\UserBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->ticketMessages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ticketMessage
     *
     * @param \Dywee\TicketBundle\Entity\TicketMessage $ticketMessage
     *
     * @return Ticket
     */
    public function addTicketMessage(\Dywee\TicketBundle\Entity\TicketMessage $ticketMessage)
    {
        $this->ticketMessages[] = $ticketMessage;
        $ticketMessage->setTicket($this);

        return $this;
    }

    /**
     * Remove ticketMessage
     *
     * @param \Dywee\TicketBundle\Entity\TicketMessage $ticketMessage
     */
    public function removeTicketMessage(\Dywee\TicketBundle\Entity\TicketMessage $ticketMessage)
    {
        $this->ticketMessages->removeElement($ticketMessage);
    }

    /**
     * Get ticketMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTicketMessages()
    {
        return $this->ticketMessages;
    }

    // Alias
    public function getMessage()
    {
        return null;
    }
    public function setMessage($message)
    {
        $messageToAdd = new TicketMessage();
        $messageToAdd->setContent($message);
        $messageToAdd->setSendedBy($this->getCreatedBy());
        return $this->addTicketMessage($messageToAdd);
    }
    public function addMessage($message){
        if(is_object($message))
            return $this->addTicketMessage($message);
        else return $this->setMessage($message);
    }
    public function removeMessage($message){    return $this->removeTicketMessage($message);    }
    public function getMessages(){              return $this->getTicketMessages();              }

    /**
     * Set category
     *
     * @param \Dywee\TicketBundle\Entity\TicketCategory $category
     *
     * @return Ticket
     */
    public function setCategory(\Dywee\TicketBundle\Entity\TicketCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Dywee\TicketBundle\Entity\TicketCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set state
     *
     * @param \Dywee\TicketBundle\Entity\TicketState $state
     *
     * @return Ticket
     */
    public function setState(\Dywee\TicketBundle\Entity\TicketState $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Dywee\TicketBundle\Entity\TicketState
     */
    public function getState()
    {
        return $this->state;
    }
}
