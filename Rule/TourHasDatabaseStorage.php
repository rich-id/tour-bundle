<?php declare(strict_types=1);

namespace RichId\TourBundle\Rule;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class TourHasDatabaseStorage
 *
 * @package   RichId\TourBundle\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TourHasDatabaseStorage
{
    /** @var array|string[] */
    private $tours;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->tours = $parameterBag->get('rich_id_tour.tours');
    }

    public function __invoke(string $tourKeyname): bool
    {
        if (!isset($this->tours[$tourKeyname])) {
            return false;
        }

        return $this->tours[$tourKeyname]['storage'] === 'database';
    }
}
