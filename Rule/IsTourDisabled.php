<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use RichId\TourBundle\Repository\TourDisabledRepository;

/**
 * Class IsTourDisabled
 *
 * @package   RichId\TourBundle\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class IsTourDisabled
{
    /** @var TourDisabledRepository */
    private $tourDisabledRepository;

    public function __construct(TourDisabledRepository $tourDisabledRepository)
    {
        $this->tourDisabledRepository = $tourDisabledRepository;
    }

    public function __invoke(string $tour): bool
    {
        $existingEntity = $this->tourDisabledRepository->findOneByTour($tour);

        return null !== $existingEntity;
    }
}
