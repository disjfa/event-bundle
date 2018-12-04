<?php

namespace Disjfa\EventBundle\EventListener;

use Disjfa\EventBundle\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    private $user;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * FullCalendarListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->entityManager = $entityManager;
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function loadEvents(CalendarEvent $calendarEvent)
    {
        if (false === $this->user instanceof UserInterface) {
            return;
        }

        $eventRepository = $this->entityManager->getRepository(Event::class);
        $events = $eventRepository->findByUserAndDates($this->user, $calendarEvent->getStart(), $calendarEvent->getEnd());
        foreach ($events as $event) {
            $calendarEvent->addEvent($event);
        }
    }
}
