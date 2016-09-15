<?php

namespace Dywee\TicketBundle\Controller;

use Dywee\NotificationBundle\Entity\Notification;
use Dywee\TicketBundle\Entity\Ticket;
use Dywee\TicketBundle\Entity\TicketCategory;
use Dywee\TicketBundle\Entity\TicketMessage;
use Dywee\TicketBundle\Form\TicketMessageType;
use Dywee\TicketBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class AdminController extends Controller
{

    public function sendMail($subject, $html){
        $message = \Swift_Message::newInstance()
            ->setSubject('AcaWeb - '.$subject)
            ->setFrom('contact@acaweb.be')
            ->setReplyTo('contact@acaweb.be')
            ->setTo('poitierjohan@gmail.com')
            ->addTo('olivier.delbruyere@hotmail.com')
            ->setBody($html, 'text/html')
        ;
        $this->get('mailer')->send($message);
    }

    public function tableAction(TicketCategory $category = null, $display = 'normal')
    {
        $ticketRepository = $this->getDoctrine()->getManager()->getRepository('DyweeTicketBundle:Ticket');
        $list = $ticketRepository->findBy(array('category' => $category));
        if ($display == 'normal')return $this->render('DyweeTicketBundle:Admin:ticket_table.html.twig', array('ticketList' => $list));
        else if($display == 'mini')return $this->render('DyweeTicketBundle:Admin:miniTable.html.twig', array('ticketList' => $list));
    }

    public function dashboardAction(User $user = null)
    {
        if($user)
        {
            $ticketRepository = $this->getDoctrine()->getManager()->getRepository('DyweeTicketBundle:Ticket');
            $list = $ticketRepository->findByHandledBy($user);
            return $this->render('DyweeTicketBundle:Ticket:table.html.twig', array('ticketList' => $list));
        }

        else
        {
            $ticketCategoryRepository = $this->getDoctrine()->getManager()->getRepository('DyweeTicketBundle:TicketCategory');
            $list = $ticketCategoryRepository->findAll();
            return $this->render('DyweeTicketBundle:Admin:dashboard.html.twig', array('categories' => $list));
        }
    }

    public function viewAction(Ticket $ticket, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ticketMessage = new TicketMessage();
        $ticketMessage->setTicket($ticket);
        $ticketMessage->setSendedBy($this->getUser());

        $ticketForm = $this->get('form.factory')->createBuilder(TicketType::class, $ticket)->getForm();

        $ticketMessageForm = $this->get('form.factory')->createBuilder(TicketMessageType::class, $ticketMessage)->getForm();

        if($ticketMessageForm->handleRequest($request)->isValid()) {
            $this->sendMail('Nouvelle réponse à un ticket', $this->renderView('DyweeTicketBundle:ForEmail:newResponse.html.twig', [
                "user" => $this->getUser(),
                "ticket" => $ticketMessage
            ]));

            $em->persist($ticketMessage);

            $ticketMessage = clone $ticketMessage;
            $ticketMessage->setContent('');
            $ticketForm = $this->get('form.factory')->createBuilder(TicketType::class, $ticket)->getForm();

            $notification = new Notification();
            $notification->setBundle('DyweeTicketBundle');
            $notification->setContent('Une réponse à un de vos ticket a été donnée: ');
            $notification->setArgument1($ticket->getSubject());
            $notification->setRoutingPath('ticket_view');
            $notification->setRoutingArguments(array('id' => $ticket->getId()));
            $notification->setType('default');
            $notification->setUser($ticket->getCreatedBy());

            $em->persist($notification);
            $em->flush();

            $ticketMessageForm = $this->get('form.factory')->createBuilder(TicketMessageType::class, $ticketMessage)->getForm();
        }

        if($ticketForm->handleRequest($request)->isValid()) {
            $em->persist($ticket);
            $em->flush();
        }

        return $this->render('DyweeTicketBundle:Admin:ticket_view.html.twig', array(
            'ticket' => $ticket,
            'ticketForm' => $ticketForm->createView(),
            'messageForm' => $ticketMessageForm->createView()
        ));
    }

    public function settingsAction()
    {
        return $this->render('DyweeTicketBundle:Admin:settings.html.twig');
    }

    public function createAction()
    {
        return new Response('TicketBundle:Admin:create');
    }

    public function endAction()
    {
        return new Response('TicketBundle:Admin:end');
    }

    public function deleteAction()
    {
        return new Response('TicketBundle:Admin:delete');
    }


}
