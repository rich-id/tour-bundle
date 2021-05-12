<?php declare(strict_types=1);

namespace RichId\TourBundle\Twig\Extension;

use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Rule\IsTourDisabled;
use RichId\TourBundle\Rule\UserHasAccessToTour;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TourExtension.
 *
 * @package   RichId\TourBundle\Twig\Extension
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourExtension extends AbstractExtension
{
    /** @var UserTourRepository */
    private $userTourRepository;

    /** @var UserHasAccessToTour */
    private $userHasAccessToTour;

    /** @var IsTourDisabled */
    private $isTourDisabled;

    /** @var array*/
    private $tours;

    public function __construct(
        UserTourRepository $userTourRepository,
        UserHasAccessToTour $userHasAccessToTour,
        IsTourDisabled $isTourDisabled,
        ParameterBagInterface $parameterBag)
    {
        $this->userTourRepository = $userTourRepository;
        $this->userHasAccessToTour = $userHasAccessToTour;
        $this->isTourDisabled = $isTourDisabled;
        $this->tours = $parameterBag->get('rich_id_tour.tours');
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getTours', [$this, 'getTours']),
            new TwigFunction('hasAccessToTour', [$this, 'hasAccessToTour']),
            new TwigFunction('isTourDisabled', [$this, 'isTourDisabled']),
            new TwigFunction('getToursStatistics', [$this, 'getToursStatistics']),
        ];
    }

    public function getTours(): array
    {
        return $this->tours;
    }

    public function hasAccessToTour(string $tour): bool
    {
        return ($this->userHasAccessToTour)($tour);
    }

    public function isTourDisabled(string $tour): bool
    {
        return ($this->isTourDisabled)($tour);
    }

    public function getToursStatistics(): array
    {
        return $this->userTourRepository->findStatistics();
    }
}

