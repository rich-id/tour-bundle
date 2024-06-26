<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Entity\Tour;
use RichId\TourBundle\Entity\UserTour;
use RichId\TourBundle\Event\TourPerformedEvent;
use RichId\TourBundle\Exception\DisabledTourException;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\UnsupportedActionStorageException;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Rule\TourExists;
use RichId\TourBundle\Rule\TourHasDatabaseStorage;
use RichId\TourBundle\Rule\TourIsDisabled;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class PerformTour
 *
 * @package   RichId\TourBundle\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class PerformTour
{
    /** @var Security */
    private $security;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TourExists */
    private $tourExists;

    /** @var TourHasDatabaseStorage */
    private $tourHasDatabaseStorage;

    /** @var TourIsDisabled */
    private $tourIsDisabled;

    /** @var TourRepository */
    private $tourRepository;

    /** @var UserTourRepository */
    private $userTourRepository;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        Security $security,
        EntityManagerInterface $entityManager,
        TourExists $tourExists,
        TourHasDatabaseStorage $tourHasDatabaseStorage,
        TourIsDisabled $tourIsDisabled,
        TourRepository $tourRepository,
        UserTourRepository $userTourRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->tourExists = $tourExists;
        $this->tourHasDatabaseStorage = $tourHasDatabaseStorage;
        $this->tourIsDisabled = $tourIsDisabled;
        $this->tourRepository = $tourRepository;
        $this->userTourRepository = $userTourRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(string $tourKeyname): void
    {
        if (!($this->tourExists)($tourKeyname)) {
            throw new NotFoundTourException($tourKeyname);
        }

        if (!($this->tourHasDatabaseStorage)($tourKeyname)) {
            throw new UnsupportedActionStorageException($tourKeyname);
        }

        if (($this->tourIsDisabled)($tourKeyname)) {
            throw new DisabledTourException($tourKeyname);
        }

        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            throw new NotAuthenticatedException();
        }

        $this->eventDispatcher->dispatch(new TourPerformedEvent($tourKeyname, $user));

        $performedTour = $this->userTourRepository->findOneByUserAndTour($user, $tourKeyname);

        if ($performedTour !== null) {
            return;
        }

        $tour = $this->tourRepository->findOneByKeyname($tourKeyname);

        if ($tour === null) {
            $tour = Tour::build($tourKeyname);
            $this->entityManager->persist($tour);
        }

        $userTour = UserTour::buildForTourAndUser($tour, $user);
        $this->entityManager->persist($userTour);
    }
}
