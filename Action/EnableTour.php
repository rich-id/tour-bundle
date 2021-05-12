<?php declare(strict_types=1);

namespace RichId\TourBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use RichId\TourBundle\Entity\Tour;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Rule\TourExists;

/**
 * Class EnableTour
 *
 * @package   RichId\TourBundle\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class EnableTour
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TourExists */
    private $tourExists;

    /** @var TourRepository */
    private $tourRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        TourExists $tourExists,
        TourRepository $tourRepository
    ) {
        $this->entityManager = $entityManager;
        $this->tourExists = $tourExists;
        $this->tourRepository = $tourRepository;
    }

    public function __invoke(string $tourKeyname): void
    {
        if (!($this->tourExists)($tourKeyname)) {
            throw new NotFoundTourException($tourKeyname);
        }

        $tour = $this->tourRepository->findOneByKeyname($tourKeyname);

        if ($tour === null) {
            $tour = Tour::build($tourKeyname);
        }

        $tour->enable();

        $this->entityManager->persist($tour);
    }
}
