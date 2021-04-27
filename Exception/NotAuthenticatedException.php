<?php declare(strict_types=1);

namespace RichId\TourBundle\Exception;

/**
 * Class NotAuthenticatedException.
 *
 * @package   RichId\TourBundle\Exception
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class NotAuthenticatedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('You must be connected');
    }
}
