<?php declare(strict_types=1);

namespace RichId\TourBundle\Event;

use RichId\TourBundle\Entity\UserTourInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TourPerformedEvent extends Event
{
    /** @var string */
    protected $tourId;

    /** @var UserTourInterface */
    protected $user;

    public function __construct(string $tourId, UserTourInterface $user)
    {
        $this->tourId = $tourId;
        $this->user = $user;
    }

    public function getTourId(): string
    {
        return $this->tourId;
    }

    public function getUser(): UserTourInterface
    {
        return $this->user;
    }
}
