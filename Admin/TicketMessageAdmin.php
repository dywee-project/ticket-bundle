<?php
/**
 * @author: Olivier Delbruyère
 * @Date: 31/03/16
 */

namespace Dywee\TicketBundle\Admin;

use Dywee\TicketBundle\Entity\TicketCategory;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TicketMessageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('content', 'textarea')
        ;
    }
}

