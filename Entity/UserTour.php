<?php declare(strict_types=1);

namespace RichId\TourBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserTour.
 *
 * @package   RichId\TourBundle\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @ORM\Entity(repositoryClass="RichId\TourBundle\Repository\UserTourRepository")
 * @ORM\Table(name="rich_id_user_tour")
 */
class UserTour
{
    /**
     * @var Tour
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RichId\TourBundle\Entity\Tour")
     * @ORM\JoinColumn(name="tour_keyname", referencedColumnName="keyname", nullable=false)
     */
    protected $tour;

    /**
     * @var UserTourInterface
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RichId\TourBundle\Entity\UserTourInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    public static function buildForTourAndUser(Tour $tour, UserTourInterface $user): self
    {
        $entity = new self();

        $entity->tour = $tour;
        $entity->user = $user;

        return $entity;
    }
}
