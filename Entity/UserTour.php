<?php declare(strict_types=1);

namespace RichId\TourBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Entity\Tour;
use RichId\TourBundle\Entity\UserTourInterface;

/**
 * Class UserTour.
 *
 * @package   RichId\TourBundle\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
#[ORM\Entity(repositoryClass: UserTourRepository::class)]
#[ORM\Table(name: 'rich_id_user_tour')]
class UserTour
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Tour::class)]
    #[ORM\JoinColumn(name: 'tour_keyname', referencedColumnName: 'keyname', nullable: false, onDelete: 'CASCADE')]
    protected Tour $tour;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: UserTourInterface::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected UserTourInterface $user;

    public function getTour(): Tour
    {
        return $this->tour;
    }

    public function getUser(): UserTourInterface
    {
        return $this->user;
    }

    public static function buildForTourAndUser(Tour $tour, UserTourInterface $user): self
    {
        $entity = new self();

        $entity->tour = $tour;
        $entity->user = $user;

        return $entity;
    }
}
