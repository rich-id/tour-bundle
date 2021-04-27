<?php declare(strict_types=1);

namespace RichId\TourBundle\Twig\Extension;

use RichId\TourBundle\Rule\UserHasAccessToTour;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class UserTourExtension.
 *
 * @package   RichId\TourBundle\Twig\Extension
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserTourExtension extends AbstractExtension
{
    /** @var UserHasAccessToTour */
    private $userHasAccessToTour;

    public function __construct(UserHasAccessToTour $userHasAccessToTour)
    {
        $this->userHasAccessToTour = $userHasAccessToTour;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('hasAccessToTour', [$this, 'hasAccessToTour']),
        ];
    }

    public function hasAccessToTour(string $tour): bool
    {
        return ($this->userHasAccessToTour)($tour);
    }
}
