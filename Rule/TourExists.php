<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class TourExists
 *
 * @package   RichId\TourBundle\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourExists
{
    /** @var array|string[] */
    private $tours;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->tours = \array_keys($parameterBag->get('rich_id_tour.tours'));
    }

    public function __invoke(string $tourKeyname): bool
    {
        return \in_array($tourKeyname, $this->tours, true);
    }
}
