<?php declare(strict_types=1);

namespace RichId\TourBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use RichId\TourBundle\Entity\UserTour;
use RichId\TourBundle\Entity\UserTourInterface;

/**
 * Class UserTourRepository.
 *
 * @package   RichId\TourBundle\Repository
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class UserTourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTour::class);
    }

    public function deleteByTour(string $tourKeyname): void
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->delete(UserTour::class, 'ut')
            ->where('ut.tour = :keyname')
            ->setParameter('keyname', $tourKeyname)
            ->getQuery()
            ->execute();
    }

    public function findOneByUserAndTour(UserTourInterface $user, string $tourKeyname): ?UserTour
    {
        $qb = $this->createQueryBuilder('ut');

        return $qb->join('ut.tour' , 't')
            ->where('t.keyname = :keyname')
            ->andWhere('ut.user = :user')
            ->setParameters(
                [
                    'keyname' => $tourKeyname,
                    'user'    => $user->getId(),
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findStatistics(): array
    {
        $qb = $this->createQueryBuilder('ut');

        $statistics = [];

        $datas = $qb->select('t.keyname')
            ->addSelect('COUNT(ut.user)')
            ->join('ut.tour', 't')
            ->groupBy('ut.tour')
            ->getQuery()
            ->getResult();

        foreach ($datas as $data) {
            $statistics[$data['keyname']] = (int) $data[1];
        }

        return $statistics;
    }
}
