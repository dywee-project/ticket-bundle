<?php
/**
 * @author: Olivier Delbruyère
 * @Date: 31/03/16
 */

namespace Dywee\TicketBundle\Admin;

use Dywee\TicketBundle\Entity\Ticket;
use Dywee\TicketBundle\Entity\TicketCategory;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TicketAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('category', 'sonata_type_model', array(
                'class' => 'DyweeTicketBundle:TicketCategory',
                'property' => 'name',
            ))
            ->add('title', 'text', array('label' => 'Category name'))
            ->add('ticketMessages', 'sonata_type_collection', array(
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
    }

    public function toString($object)
    {
        return $object instanceof Ticket
            ? $object->getTitle()
            : 'Ticket';
    }
}

