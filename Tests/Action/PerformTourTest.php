<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Action;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Action\PerformTour;
use RichId\TourBundle\Exception\DisabledTourException;
use RichId\TourBundle\Exception\NotAuthenticatedException;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\UnsupportedActionStorageException;
use RichId\TourBundle\Repository\TourRepository;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

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
        $this->authenticate(DummyUser::class, '1');

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNull($tour);

        ($this->action)('database_tour_3');
        $this->getManager()->flush();

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNotNull($tour);
    }
}