<?php declare(strict_types=1);

namespace RichId\TourBundle\Exception;

/**
 * Class DisabledTourException.
 *
 * @package   RichId\TourBundle\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class DisabledTourException extends \Exception
{
    public function __construct(string $tour)
    {
        parent::__construct(\sprintf('Tour %s is disabled', $tour));
    }
}
