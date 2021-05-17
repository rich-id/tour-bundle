<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use RichId\TourBundle\Repository\TourRepository;

/**
 * Class TourIsDisabled
 *
 * @package   RichId\TourBundle\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourIsDisabled
{
    /** @var TourRepository */
    private $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function __invoke(string $tourKeyname): bool
    {
        $tour = $this->tourRepository->findOneByKeyname($tourKeyname);

        return $tour !== null && $tour->isDisabled();
    }
}
