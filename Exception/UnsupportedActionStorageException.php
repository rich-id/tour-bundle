<?php declare(strict_types=1);

namespace RichId\TourBundle\Exception;

/**
 * Class UnsupportedActionStorageException.
 *
 * @package   RichId\TourBundle\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UnsupportedActionStorageException extends TourException
{
    public function __construct(string $tour)
    {
        parent::__construct(\sprintf('The storage of the %s tour must be of database type', $tour));
    }
}
