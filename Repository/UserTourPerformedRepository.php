<?php declare(strict_types=1);

namespace RichId\TourBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use RichId\TourBundle\Entity\UserTourPerformed;

/**
 * Class UserTourPerformedRepository.
 *
 * @package   RichId\TourBundle\Repository
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserTourPerformedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTourPerformed::class);
    }

    public function deleteByTour(string $tour): void
    {
        $qb = $this->createQueryBuilder('t');

        $qb->delete('t')
            ->where('t.tour = :tour')
            ->setParameter('tour', $tour)
            ->getQuery()
            ->execute();
    }
}
