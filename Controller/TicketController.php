<?php

namespace Dywee\TicketBundle\Controller;

use Dywee\TicketBundle\Entity\Ticket;
use Dywee\TicketBundle\Entity\TicketCategory;
use Dywee\TicketBundle\Entity\TicketMessage;
use Dywee\TicketBundle\Form\TicketForUserType;
use Dywee\TicketBundle\Form\TicketMessageType;
use Dywee\TicketBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class TicketController extends Controller
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

    public function dashboardAction()
    {
        $ticketCategoryRepository = $this->getDoctrine()->getManager()->getRepository('DyweeTicketBundle:TicketCategory');
        $list = $ticketCategoryRepository->findByCreatedBy($this->getUser());
        return $this->render('DyweeTicketBundle:Ticket:dashboard.html.twig', array('categories' => $list));
    }

    public function tableAction($display = 'normal')
    {
        $ticketRepository = $this->getDoctrine()->getManager()->getRepository('DyweeTicketBundle:Ticket');
        $list = $ticketRepository->findByCreatedBy($this->getUser());
        if ($display == 'normal')return $this->render('DyweeTicketBundle:Ticket:table.html.twig', array('ticketList' => $list));
        else if($display == 'mini')return $this->render('DyweeTicketBundle:Ticket:miniTable.html.twig', array('ticketList' => $list));
    }

    public function viewAction(Ticket $ticket, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ticketMessage = new TicketMessage();
        $ticketMessage->setTicket($ticket);
        $ticketMessage->setSendedBy($this->getUser());

        $ticketMessageForm = $this->get('form.factory')->createBuilder(TicketMessageType::class, $ticketMessage)->getForm();

        if($ticketMessageForm->handleRequest($request)->isValid())
        {


            /*
            $this->sendMail('Nouvelle réponse à un ticket', $this->renderView('DyweeTicketBundle:ForEmail:newResponse.html.twig', [
                "user" => $this->getUser(),
                "ticket" => $ticketMessage
            ]));
            */

            $em->persist($ticketMessage);
            $em->flush();

            $ticketMessage = clone $ticketMessage;
            $ticketMessage->setContent('');
        }

        return $this->render('DyweeTicketBundle:Ticket:view.html.twig', array(
            'ticket' => $ticket,
            'messageForm' => $ticketMessageForm->createView()
        ));
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ticket = new Ticket();
        $ticket->setCreatedBy($this->getUser());
        $ticket->setState($em->getRepository('DyweeTicketBundle:TicketState')->findOneByName('En attente'));

        $ticketForm = $this->get('form.factory')->createBuilder(TicketForUserType::class, $ticket)->getForm();

        if($ticketForm->handleRequest($request)->isValid())
        {
            $em->persist($ticket);
            $em->flush();

            /*
            $this->sendMail(
                'Nouveau ticket posté',
                $this->renderView('DyweeTicketBundle:ForEmail:newTicket.html.twig', [
                    "user" => $this->getUser(),
                    "ticket" => $ticket,
                ])
            );
            */

            $request->getSession()->getFlashBag()->set('success', 'Ticket créé, nous allons le traiter au plus vite');

            return $this->redirect($this->generateUrl('ticket_dashboard'));
        }

        else return $this->render('DyweeTicketBundle:Ticket:add.html.twig', array('form' => $ticketForm->createView()));
    }
}
