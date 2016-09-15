<?php

namespace Dywee\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketMessage
 *
 * @ORM\Table(name="ticket_message")
 * @ORM\Entity(repositoryClass="TicketBundle\Repository\TicketMessageRepository")
 */
class TicketMessage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(name="content", type="text") */
    private $content;

    /** @ORM\Column(name="sendedAt", type="datetime") */
    private $sendedAt;

    /** @ORM\Column(name="seenAt", type="datetime", nullable=true) */
    private $seenAt;

    /** @ORM\ManyToOne(targetEntity="Ticket", inversedBy="ticketMessages") */
    private $ticket;

    /**  @ORM\ManyToOne(targetEntity="UserBundle\Entity\User") */
    private $sendedBy;

    public function __construct()
    {
        $this->setSendedAt(new \DateTime());
    }

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
     * Set content
     *
     * @param string $content
     *
     * @return TicketMessage
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set sendedAt
     *
     * @param \DateTime $sendedAt
     *
     * @return TicketMessage
     */
    public function setSendedAt($sendedAt)
    {
        $this->sendedAt = $sendedAt;

        return $this;
    }

    /**
     * Get sendedAt
     *
     * @return \DateTime
     */
    public function getSendedAt()
    {
        return $this->sendedAt;
    }

    /**
     * Set seenAt
     *
     * @param string $seenAt
     *
     * @return TicketMessage
     */
    public function setSeenAt($seenAt)
    {
        $this->seenAt = $seenAt;

        return $this;
    }

    /**
     * Get seenAt
     *
     * @return string
     */
    public function getSeenAt()
    {
        return $this->seenAt;
    }

    /**
     * Set ticket
     *
     * @param \Dywee\TicketBundle\Entity\Ticket $ticket
     *
     * @return TicketMessage
     */
    public function setTicket(\Dywee\TicketBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \Dywee\TicketBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    public function view()
    {
        return $this->getContent();
    }

    /**
     * Set sendedBy
     *
     * @param \UserBundle\Entity\User $sendedBy
     *
     * @return TicketMessage
     */
    public function setSendedBy(\UserBundle\Entity\User $sendedBy = null)
    {
        $this->sendedBy = $sendedBy;

        return $this;
    }

    /**
     * Get sendedBy
     *
     * @return \UserBundle\Entity\User
     */
    public function getSendedBy()
    {
        return $this->sendedBy;
    }
}
