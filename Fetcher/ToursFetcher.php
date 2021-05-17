<?php declare(strict_types=1);

namespace RichId\TourBundle\Fetcher;

use RichId\TourBundle\Repository\TourRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class ToursFetcher
 *
 * @package   RichId\TourBundle\Fetcher
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class ToursFetcher
{
    /** @var array */
    private $tours;

    /** @var TourRepository */
    private $tourRepository;

    public function __construct(ParameterBagInterface $parameterBag, TourRepository $tourRepository)
    {
        $this->tours = $parameterBag->get('rich_id_tour.tours');
        $this->tourRepository = $tourRepository;
    }

    public function __invoke(): array
    {
        $disabledTours = $this->tourRepository->findDisabledTourKeynames();
        $tours = [];

        foreach ($this->tours as $tourName => $tour) {
            $date = new \DateTime('today midnight ' . $tour['duration']);

            $tours[$tourName] = $tour;
            $tours[$tourName]['expiresDate'] = $date->format('Y-m-d');
            $tours[$tourName]['isDisabled'] = \in_array($tourName, $disabledTours, true);
        }

        return $tours;
    }
}
