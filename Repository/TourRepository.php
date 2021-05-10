<?php declare(strict_types=1);

namespace RichId\TourBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use RichId\TourBundle\Entity\Tour;

/**
 * Class TourRepository.
 *
 * @package   RichId\TourBundle\Repository
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @method Tour|null findOneByKeyname(string $tourKeyname)
 */
class TourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tour::class);
    }
}
