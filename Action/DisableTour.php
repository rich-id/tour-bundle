<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Entity\TourDisabled;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\TourDisabledRepository;
use RichId\TourBundle\Rule\UserTourExists;

/**
 * Class DisableTour
 *
 * @package   RichId\TourBundle\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class DisableTour
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserTourExists */
    private $userTourExists;

    /** @var TourDisabledRepository */
    private $tourDisabledRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserTourExists $userTourExists,
        TourDisabledRepository $tourDisabledRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userTourExists = $userTourExists;
        $this->tourDisabledRepository = $tourDisabledRepository;
    }

    public function __invoke(string $tour): void
    {
        if (!($this->userTourExists)($tour)) {
            throw new NotFoundTourException($tour);
        }

        $existingEntity = $this->tourDisabledRepository->findOneByTour($tour);

        if ($existingEntity !== null) {
            return;
        }

        $entity = TourDisabled::buildForTour($tour);

        $this->entityManager->persist($entity);
    }
}
