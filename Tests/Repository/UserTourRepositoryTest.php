<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Repository;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Entity\UserTour;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

/**
 * Class UserTourRepositoryTest
 *
 * @package   RichId\TourBundle\Tests\Repository
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Repository\UserTourRepository
 * @TestConfig("fixtures")
 */
final class UserTourRepositoryTest extends TestCase
{
    /** @var UserTourRepository */
    public $repository;

    public function testDeleteByTourKeyname(): void
    {
        $this->assertCount(1, $this->repository->findAll());

        $this->repository->deleteByTourKeyname('database_tour_4');
        $this->assertEmpty($this->repository->findAll());
    }

    public function testFindOneByUserAndTourNotFound(): void
    {
        $user = $this->getReference(DummyUser::class, '1');

        $result = $this->repository->findOneByUserAndTour($user, 'database_tour');
        $this->assertNull($result);
    }

    public function testFindOneByUserAndTour(): void
    {
        $user = $this->getReference(DummyUser::class, '1');

        $result = $this->repository->findOneByUserAndTour($user, 'database_tour_4');
        $this->assertInstanceOf(UserTour::class, $result);
    }

    public function testFindPerformedTourKeynamesForUserEmpty(): void
    {
        $user = $this->getReference(DummyUser::class, '2');

        $results = $this->repository->findPerformedTourKeynamesForUser($user);
        $this->assertSame([], $results);
    }

    public function testFindPerformedTourKeynamesForUser(): void
    {
        $user = $this->getReference(DummyUser::class, '1');

        $results = $this->repository->findPerformedTourKeynamesForUser($user);
        $this->assertSame(['database_tour_4'], $results);
    }

    public function testFindStatistics(): void
    {
        $results = $this->repository->findStatistics();
        $this->assertSame(['database_tour_4' => 1], $results);
    }
}
