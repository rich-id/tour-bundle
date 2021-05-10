<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Entity\Tour;
use RichId\TourBundle\Entity\UserTour;
use RichId\TourBundle\Exception\DisabledTourException;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Rule\IsTourDisabled;
use RichId\TourBundle\Rule\UserTourExists;
use Symfony\Component\Security\Core\Security;

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

    /** @var UserTourExists */
    private $userTourExists;

    /** @var IsTourDisabled */
    private $isTourDisabled;

    /** @var TourRepository */
    private $tourRepository;

    /** @var UserTourRepository */
    private $userTourRepository;

    public function __construct(
        Security $security,
        EntityManagerInterface $entityManager,
        UserTourExists $userTourExists,
        IsTourDisabled $isTourDisabled,
        TourRepository $tourRepository,
        UserTourRepository $userTourRepository
    ) {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->userTourExists = $userTourExists;
        $this->isTourDisabled = $isTourDisabled;
        $this->tourRepository = $tourRepository;
        $this->userTourRepository = $userTourRepository;
    }

    public function __invoke(string $tourKeyname): void
    {
        if (!($this->userTourExists)($tourKeyname)) {
            throw new NotFoundTourException($tourKeyname);
        }

        if (($this->isTourDisabled)($tourKeyname)) {
            throw new DisabledTourException($tourKeyname);
        }

        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            throw new NotAuthenticatedException();
        }

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
