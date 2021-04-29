<?php declare(strict_types=1);

namespace RichId\TourBundle\UseCase;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Entity\UserTourPerformed;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\UserTourPerformedRepository;
use RichId\TourBundle\Validator\UserTourExist;
use Symfony\Component\Security\Core\Security;

/**
 * Class PerformTour
 *
 * @package   RichId\TourBundle\UseCase
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class PerformTour
{
    /** @var Security */
    private $security;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserTourExist */
    private $userTourExist;

    /** @var UserTourPerformedRepository */
    private $userTourPerformedRepository;

    public function __construct(
        Security $security,
        EntityManagerInterface $entityManager,
        UserTourExist $userTourExist,
        UserTourPerformedRepository $userTourPerformedRepository
    ) {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->userTourExist = $userTourExist;
        $this->userTourPerformedRepository = $userTourPerformedRepository;
    }

    public function __invoke(string $tour): void
    {
        if (!($this->userTourExist)($tour)) {
            throw new NotFoundTourException($tour);
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
