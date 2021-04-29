<?php declare(strict_types=1);

namespace RichId\TourBundle\Twig\Extension;

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
    /** @var UserHasAccessToTour */
    private $userHasAccessToTour;

    /** @var array|string[] */
    private $userTours;

    public function __construct(UserHasAccessToTour $userHasAccessToTour, ParameterBagInterface $parameterBag)
    {
        $this->userHasAccessToTour = $userHasAccessToTour;
        $this->userTours = $parameterBag->get('rich_id_tour.user_tours');
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getAllowedTours', [$this, 'getAllowedTours']),
            new TwigFunction('hasAccessToTour', [$this, 'hasAccessToTour']),
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
}
