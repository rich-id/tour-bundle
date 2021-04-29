<?php declare(strict_types=1);

namespace RichId\TourBundle\UseCase;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\TourDisabledRepository;
use RichId\TourBundle\Validator\UserTourExist;

/**
 * Class EnabledTour
 *
 * @package   RichId\TourBundle\UseCase
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class EnabledTour
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserTourExist */
    private $userTourExist;

    /** @var TourDisabledRepository */
    private $tourDisabledRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserTourExist $userTourExist,
        TourDisabledRepository $tourDisabledRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userTourExist = $userTourExist;
        $this->tourDisabledRepository = $tourDisabledRepository;
    }

    public function __invoke(string $tour): void
    {
        if (!($this->userTourExist)($tour)) {
            throw new NotFoundTourException($tour);
        }

        $existingEntity = $this->tourDisabledRepository->findOneByTour($tour);

        if ($existingEntity === null) {
            return;
        }

        $this->entityManager->remove($existingEntity);
    }
}
