<?php

namespace Dywee\TicketBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TicketType extends AbstractType
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
            ->add('state',          EntityType::class, array(
                'class'         => 'DyweeTicketBundle:TicketState',
                'choice_label'  => 'name'
            ))
            ->add('handledBy',      EntityType::class, array(
                'class'         => 'UserBundle:User',
                'choice_label'  => 'completeName',
                'required'      => false
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
