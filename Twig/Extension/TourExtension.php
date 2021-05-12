<?php declare(strict_types=1);

namespace RichId\TourBundle\Twig\Extension;

use RichId\TourBundle\Entity\UserTourInterface;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Rule\IsTourDisabled;
use RichId\TourBundle\Rule\UserHasAccessToTour;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;
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
    /** @var Security */
    private $security;

    /** @var TourRepository */
    private $tourRepository;

    /** @var UserTourRepository */
    private $userTourRepository;

    /** @var UserHasAccessToTour */
    private $userHasAccessToTour;

    /** @var IsTourDisabled */
    private $isTourDisabled;

    /** @var array*/
    private $tours;

    public function __construct(
        Security $security,
        TourRepository $tourRepository,
        UserTourRepository $userTourRepository,
        UserHasAccessToTour $userHasAccessToTour,
        IsTourDisabled $isTourDisabled,
        ParameterBagInterface $parameterBag)
    {
        $this->security = $security;
        $this->tourRepository = $tourRepository;
        $this->userTourRepository = $userTourRepository;
        $this->userHasAccessToTour = $userHasAccessToTour;
        $this->isTourDisabled = $isTourDisabled;
        $this->tours = $parameterBag->get('rich_id_tour.tours');
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getTours', [$this, 'getTours']),
            new TwigFunction('getPerformedToursForCurrentUser', [$this, 'getPerformedToursForCurrentUser']),
            new TwigFunction('hasAccessToTour', [$this, 'hasAccessToTour']),
            new TwigFunction('isTourDisabled', [$this, 'isTourDisabled']),
            new TwigFunction('getToursStatistics', [$this, 'getToursStatistics']),
        ];
    }

    public function getTours(): array
    {
        $disabledTours = $this->tourRepository->findDisabledTourKeynames();
        $tours = [];

        foreach ($this->tours as $tourName => $tour) {
            $tours[$tourName] = $tour;
            $tours[$tourName]['isDisabled'] = \in_array($tourName, $disabledTours, true);
        }

        return $tours;
    }

    public function getPerformedToursForCurrentUser(): array
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserTourInterface) {
            return [];
        }

        return $this->userTourRepository->findPerformedTourKeynamesForUser($user);
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

