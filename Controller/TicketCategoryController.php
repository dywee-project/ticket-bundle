<?php

namespace Dywee\TicketBundle\Controller;

use Dywee\TicketBundle\Entity\Ticket;
use Dywee\TicketBundle\Entity\TicketCategory;
use Dywee\TicketBundle\Entity\TicketMessage;
use Dywee\TicketBundle\Form\TicketMessageType;
use Dywee\TicketBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class TicketCategoryController extends ParentController
{
    protected $entityName = 'TicketCategory';
    protected $publicName = 'Catégorie de ticket';
    protected $tableViewName = 'admin_ticket_settings';

    public function miniTableAction()
    {
        $ticketCategoryRepository = $this->getDoctrine()->getRepository('DyweeTicketBundle:TicketCategory');
        $ticketCategoryList = $ticketCategoryRepository->findAll();

        return $this->render('DyweeTicketBundle:TicketCategory:minitable.html.twig', array('ticketCategoryList' => $ticketCategoryList));
    }
}
