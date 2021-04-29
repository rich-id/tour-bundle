<?php declare(strict_types=1);

namespace RichId\TourBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserTourPerformed.
 *
 * @package   RichId\TourBundle\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @ORM\Entity(repositoryClass="RichId\TourBundle\Repository\UserTourPerformedRepository")
 * @ORM\Table(name="rich_id_user_tour_performed"
 */
class UserTourPerformed
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=255, nullable=false, name="tour")
     *
     */
    protected $tour;

    /**
     * @var UserTourInterface
     *
     * @ORM\ManyToOne(targetEntity="RichId\TourBundle\Entity\UserTourInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    public static function buildForUserAndTour(UserTourInterface $user, string $tour): self
    {
        $entity = new self();

        $entity->user = $user;
        $entity->tour = $tour;

        return $entity;
    }
}
