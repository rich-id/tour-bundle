<?php declare(strict_types=1);

namespace RichId\TourBundle\Model;

/**
 * Class UserTourPerformed.
 *
 * @package   RichId\TourBundle\Model
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserTourPerformed
{
   /** @var @var string */
    protected $tour;

    /** @var @var UserTourInterface */
    protected $user;

    public static function buildForUserAndTour(UserTourInterface $user, string $tour): self
    {
        $entity = new self();

        $entity->user = $user;
        $entity->tour = $tour;

        return $entity;
    }
}
