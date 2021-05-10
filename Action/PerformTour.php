<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Exception\DisabledTourException;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Entity\UserTourPerformed;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\UserTourPerformedRepository;
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

    /** @var UserTourPerformedRepository */
    private $userTourPerformedRepository;

    public function __construct(
        Security $security,
        EntityManagerInterface $entityManager,
        UserTourExists $userTourExists,
        IsTourDisabled $isTourDisabled,
        UserTourPerformedRepository $userTourPerformedRepository
    ) {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->userTourExists = $userTourExists;
        $this->isTourDisabled = $isTourDisabled;
        $this->userTourPerformedRepository = $userTourPerformedRepository;
    }

    public function __invoke(string $tour): void
    {
        if (!($this->userTourExists)($tour)) {
            throw new NotFoundTourException($tour);
        }

        if (($this->isTourDisabled)($tour)) {
            throw new DisabledTourException($tour);
        }

        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            throw new NotAuthenticatedException();
        }

        $existingEntity = $this->userTourPerformedRepository->findOneBy(
            [
                'user' => $user->getId(),
                'tour' => $tour,
            ]
        );

        if ($existingEntity !== null) {
            return;
        }

        $entity = UserTourPerformed::buildForUserAndTour($user, $tour);

        $this->entityManager->persist($entity);
    }
}
