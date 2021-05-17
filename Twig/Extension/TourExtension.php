<?php declare(strict_types=1);

namespace RichId\TourBundle\Twig\Extension;

use RichId\TourBundle\Fetcher\PerformedToursForCurrentUserFetcher;
use RichId\TourBundle\Fetcher\ToursFetcher;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Rule\TourIsDisabled;
use RichId\TourBundle\Rule\UserHasAccessToTour;
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
    /** @var PerformedToursForCurrentUserFetcher */
    private $performedToursForCurrentUserFetcher;

    /** @var ToursFetcher */
    private $toursFetcher;

    /** @var UserTourRepository */
    private $userTourRepository;

    /** @var UserHasAccessToTour */
    private $userHasAccessToTour;

    /** @var TourIsDisabled */
    private $tourIsDisabled;

    public function __construct(
        PerformedToursForCurrentUserFetcher $performedToursForCurrentUserFetcher,
        ToursFetcher $toursFetcher,
        UserTourRepository $userTourRepository,
        UserHasAccessToTour $userHasAccessToTour,
        TourIsDisabled $tourIsDisabled
    ) {
        $this->performedToursForCurrentUserFetcher = $performedToursForCurrentUserFetcher;
        $this->toursFetcher = $toursFetcher;
        $this->userTourRepository = $userTourRepository;
        $this->userHasAccessToTour = $userHasAccessToTour;
        $this->tourIsDisabled = $tourIsDisabled;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getPerformedToursForCurrentUser', [$this, 'getPerformedToursForCurrentUser']),
            new TwigFunction('getTours', [$this, 'getTours']),
            new TwigFunction('getToursStatistics', [$this, 'getToursStatistics']),
            new TwigFunction('hasAccessToTour', [$this, 'hasAccessToTour']),
            new TwigFunction('isTourDisabled', [$this, 'isTourDisabled']),
        ];
    }

    public function getPerformedToursForCurrentUser(): array
    {
        return ($this->performedToursForCurrentUserFetcher)();
    }

    public function getTours(): array
    {
        return ($this->toursFetcher)();
    }

    public function getToursStatistics(): array
    {
        return $this->userTourRepository->findStatistics();
    }

    public function hasAccessToTour(string $tour): bool
    {
        return ($this->userHasAccessToTour)($tour);
    }

    public function isTourDisabled(string $tour): bool
    {
        return ($this->tourIsDisabled)($tour);
    }
}

