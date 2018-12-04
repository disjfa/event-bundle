<?php

namespace Disjfa\EventBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\UserInterface;

class EventRepository extends EntityRepository
{
    /**
     * @param UserInterface $user
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return Event[]
     */
    public function findByUserAndDates(UserInterface $user, DateTime $startDate, DateTime $endDate)
    {
        $qb = $this->createQueryBuilder('event');
        $qb->where('event.userId = :userId');
        $qb->andWhere('event.startDate >= :startDate');
        $qb->andWhere('event.startDate <= :endDate');
        $qb->setParameter('userId', $user->getId());
        $qb->setParameter('startDate', $startDate);
        $qb->setParameter('endDate', $endDate);

        return $qb->getQuery()->getResult();
    }
}
