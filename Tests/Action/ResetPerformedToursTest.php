<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Action;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Action\ResetPerformedTours;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Exception\UnsupportedActionStorageException;
use RichId\TourBundle\Repository\UserTourRepository;

/**
 * Class ResetPerformedToursTest
 *
 * @package   RichId\TourBundle\Tests\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Action\ResetPerformedTours
 */
#[TestConfig('fixtures')]
final class ResetPerformedToursTest extends TestCase
{
    /** @var ResetPerformedTours */
    public $action;

    /** @var UserTourRepository */
    public $userTourRepository;

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

    public function testActionSuccess(): void
    {
        $this->assertCount(1, $this->userTourRepository->findAll());

        ($this->action)('database_tour_4');

        $this->assertEmpty($this->userTourRepository->findAll());
    }
}
