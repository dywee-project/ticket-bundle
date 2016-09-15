<?php // DyweeTicketBundle/DataFixtures/ORM/LoadTicketCategory

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dywee\TicketBundle\Entity\Ticket;
use Dywee\TicketBundle\Entity\TicketCategory;
use Dywee\TicketBundle\Entity\TicketMessage;
use Dywee\TicketBundle\Entity\TicketState;

class LoadTicketCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cateogry1 = new TicketCategory();
        $cateogry1->setName('Problème technique');

        $category2 = new TicketCategory();
        $category2->setName('Aide');

        $category3 = new TicketCategory();
        $category3->setName('Commercial');

        $ticket1 = new Ticket();
        $ticket1->setCategory($cateogry1);
        $ticket1->setTitle('Ticket de test 1');

        $ticket2 = new Ticket();
        $ticket2->setCategory($cateogry1);
        $ticket2->setTitle('Ticket de test 1');

        $ticketMessage1 = new TicketMessage();
        $ticketMessage1->setContent('<p>Contenu de test</p>');

        $ticketMessage2 = new TicketMessage();
        $ticketMessage2->setContent('<p>Contenu de test 1 </p>');

        $ticketMessage3 = new TicketMessage();
        $ticketMessage3->setContent('<p>Contenu de test 2</p>');

        $ticket1->addTicketMessage($ticketMessage1);
        $ticket2->addTicketMessage($ticketMessage2)->addTicketMessage($ticketMessage3);

        $state1 = new TicketState();
        $state1->setName('En attente');
        $state1->setColor('warning');

        $state2 = new TicketState();
        $state2->setName('En cours');
        $state2->setColor('primary');

        $state3 = new TicketState();
        $state3->setColor('success');
        $state3->setName('Finalisé');

        $ticket1->setState($state1);
        $ticket2->setState($state1);

        $manager->persist($state1);
        $manager->persist($state2);
        $manager->persist($state3);

        $manager->persist($cateogry1);
        $manager->persist($category2);
        $manager->persist($category3);

        $manager->persist($ticket1);
        $manager->persist($ticket2);

        $manager->flush();
    }
}