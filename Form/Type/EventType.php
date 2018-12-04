<?php

namespace Disjfa\EventBundle\Form\Type;

use Disjfa\EventBundle\Entity\Event;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Toiba\FullCalendarBundle\Form\Type\EventType as BaseEventType;

class EventType extends BaseEventType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
