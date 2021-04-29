<?php declare(strict_types=1);

namespace RichId\TourBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TourDisabled.
 *
 * @package   RichId\TourBundle\Entity
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @ORM\Entity(repositoryClass="RichId\TourBundle\Repository\TourDisabledRepository")
 * @ORM\Table(name="rich_id_tour_disabled")
 */
class TourDisabled
{
    /**
     *  @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=255, nullable=false, name="tour")
     *
     */
    protected $tour;

    public static function buildForTour(string $tour): self
    {
        $entity = new self();
        $entity->tour = $tour;

        return $entity;
    }
}
