<?php

namespace Disjfa\EventBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use FOS\UserBundle\Model\UserInterface;
use Ramsey\Uuid\Uuid;
use Toiba\FullCalendarBundle\Entity\EventInterface;
use Toiba\FullCalendarBundle\Entity\OrmEventTrait;

/**
 * @ORM\Entity(repositoryClass="Disjfa\EventBundle\Entity\EventRepository")
 * @ORM\Table(name="event")
 */
class Event implements EventInterface
{
    use OrmEventTrait;
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="user_id", type="string")
     */
    private $userId;

    /**
     * @param UserInterface $user
     * @throws Exception
     */
    public function __construct(UserInterface $user)
    {
        $this->id = Uuid::uuid4();
        $this->userId = $user->getId();
        $this->startDate = new DateTime('now');
        $this->color = '#3498db';
        $this->backgroundColor = '#3498db';
        $this->textColor = '#ecf0f1';
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
}
