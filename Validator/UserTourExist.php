<?php declare(strict_types=1);

namespace RichId\TourBundle\Validator;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class UserTourExist
 *
 * @package   RichId\TourBundle\Validator
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserTourExist
{
    /** @var array|string[] */
    private $userTours;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->userTours = $parameterBag->get('rich_id_tour.user_tours');
    }

    public function __invoke(string $tour): bool
    {
        return \in_array($tour, $this->userTours, true);
    }
}
