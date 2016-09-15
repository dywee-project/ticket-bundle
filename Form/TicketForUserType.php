<?php

namespace Dywee\TicketBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dywee\TicketBundle\Form\TicketMessageType;

class TicketForUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category',       EntityType::class, array(
                'class'         => 'DyweeTicketBundle:TicketCategory',
                'choice_label'  => 'name'
            ))
            ->add('title')
            ->add('message',  TicketMessageType::class, array(
                'data_class' => null
            ))
            ->add('Valider',        SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dywee\TicketBundle\Entity\Ticket'
        ));
    }
}

