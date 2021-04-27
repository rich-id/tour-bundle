<?php declare(strict_types=1);

namespace RichId\TourBundle\Exception;

/**
 * Class NotFoundTourException.
 *
 * @package   RichId\TourBundle\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class NotFoundTourException extends \Exception
{
    public function __construct(string $tour)
    {
        parent::__construct(\sprintf('Not found tour %s', $tour));
    }
}
