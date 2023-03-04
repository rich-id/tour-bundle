<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Action;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Action\PerformTour;
use RichId\TourBundle\Event\TourPerformedEvent;
use RichId\TourBundle\Exception\DisabledTourException;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\UnsupportedActionStorageException;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Repository\UserTourRepository;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;
use RichId\TourBundle\Tests\Resources\Stub\EventDispatcherStub;

/**
 * Class PerformTourTest
 *
 * @package   RichId\TourBundle\Tests\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Action\PerformTour
 * @TestConfig("fixtures")
 */
final class PerformTourTest extends TestCase
{
    /** @var PerformTour */
    public $action;

    /** @var TourRepository */
    public $tourRepository;

    /** @var UserTourRepository */
    public $userTourRepository;

    protected function beforeTest(): void
    {
        EventDispatcherStub::setUp();
    }

    public function testActionNotExistingTour(): void
    {
        $this->expectException(NotFoundTourException::class);
        $this->expectExceptionMessage('Not found tour not_existing_tour');

        ($this->action)('not_existing_tour');
    }

    public function testActionTourWithCookieStorage(): void
    {
        $this->expectException(UnsupportedActionStorageException::class);
        $this->expectExceptionMessage('The storage of the cookie_tour tour must be of database type');

        ($this->action)('cookie_tour');
    }

    public function testActionTourWithLocalStorageStorage(): void
    {
        $this->expectException(UnsupportedActionStorageException::class);
        $this->expectExceptionMessage('The storage of the local_storage_tour tour must be of database type');

        ($this->action)('local_storage_tour');
    }

    public function testActionWithDisabledTour(): void
    {
        $this->expectException(DisabledTourException::class);
        $this->expectExceptionMessage('Tour database_tour_2 is disabled');

        ($this->action)('database_tour_2');
    }

    public function testActionNotLoggedUser(): void
    {
        $this->expectException(NotAuthenticatedException::class);
        $this->expectExceptionMessage('You must be connected');

        ($this->action)('database_tour');
    }

    public function testActionTourNotExistInDatabase(): void
    {
        $user = $this->getRepository(DummyUser::class)->find(1);
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour_3');
        $this->assertNull($tour);
        $this->assertNull($userTour);

        ($this->action)('database_tour_3');
        $this->getManager()->flush();

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour_3');
        $this->assertNotNull($tour);
        $this->assertNotNull($userTour);

        $this->assertCount(1, EventDispatcherStub::$events);
        $this->assertInstanceOf(TourPerformedEvent::class, EventDispatcherStub::$events[0]);
        $this->assertSame('database_tour_3', EventDispatcherStub::$events[0]->getTourId());
        $this->assertSame($user, EventDispatcherStub::$events[0]->getUser());
    }

    public function testActionTourAlreadyExistInDatabase(): void
    {
        $user = $this->getRepository(DummyUser::class)->find(1);
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour');
        $this->assertNotNull($tour);
        $this->assertNull($userTour);

        ($this->action)('database_tour');
        $this->getManager()->flush();

        $tour = $this->tourRepository->findOneByKeyname('database_tour');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour');
        $this->assertNotNull($tour);
        $this->assertNotNull($userTour);

        $this->assertCount(1, EventDispatcherStub::$events);
        $this->assertInstanceOf(TourPerformedEvent::class, EventDispatcherStub::$events[0]);
        $this->assertSame('database_tour', EventDispatcherStub::$events[0]->getTourId());
        $this->assertSame($user, EventDispatcherStub::$events[0]->getUser());
    }

    public function testActionTourAlreadyPerformed(): void
    {
        $user = $this->getRepository(DummyUser::class)->find(1);
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour_4');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour_4');
        $this->assertNotNull($tour);
        $this->assertNotNull($userTour);

        ($this->action)('database_tour_4');
        $this->getManager()->flush();

        $tour = $this->tourRepository->findOneByKeyname('database_tour_4');
        $userTour = $this->userTourRepository->findOneByUserAndTour($user, 'database_tour_4');
        $this->assertNotNull($tour);
        $this->assertNotNull($userTour);

        $this->assertCount(1, EventDispatcherStub::$events);
        $this->assertInstanceOf(TourPerformedEvent::class, EventDispatcherStub::$events[0]);
        $this->assertSame('database_tour_4', EventDispatcherStub::$events[0]->getTourId());
        $this->assertSame($user, EventDispatcherStub::$events[0]->getUser());
    }
}
