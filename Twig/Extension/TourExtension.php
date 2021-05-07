<?php declare(strict_types=1);

namespace RichId\TourBundle\Twig\Extension;

use RichId\TourBundle\Repository\UserTourPerformedRepository;
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
    /** @var UserTourPerformedRepository */
    private $userTourPerformedRepository;

    /** @var UserHasAccessToTour */
    private $userHasAccessToTour;

    /** @var IsTourDisabled */
    private $isTourDisabled;

    /** @var array|string[] */
    private $userTours;

    public function __construct(
        UserTourPerformedRepository $userTourPerformedRepository,
        UserHasAccessToTour $userHasAccessToTour,
        IsTourDisabled $isTourDisabled,
        ParameterBagInterface $parameterBag)
    {
        $this->userTourPerformedRepository = $userTourPerformedRepository;
        $this->userHasAccessToTour = $userHasAccessToTour;
        $this->isTourDisabled = $isTourDisabled;
        $this->userTours = $parameterBag->get('rich_id_tour.user_tours');
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getAllowedTours', [$this, 'getAllowedTours']),
            new TwigFunction('hasAccessToTour', [$this, 'hasAccessToTour']),
            new TwigFunction('isTourDisabled', [$this, 'isTourDisabled']),
            new TwigFunction('getToursStatistics', [$this, 'getToursStatistics']),
        ];
    }

    public function getAllowedTours(): array
    {
        return $this->userTours;
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
        return $this->userTourPerformedRepository->getStatistics();
    }
}

