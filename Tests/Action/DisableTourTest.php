<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Action;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Action\DisableTour;
use RichId\TourBundle\Exception\NotFoundTourException;
use RichId\TourBundle\Repository\TourRepository;

/**
 * Class DisableTourTest
 *
 * @package   RichId\TourBundle\Tests\Action
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Action\DisableTour
 */
#[TestConfig('fixtures')]
final class DisableTourTest extends TestCase
{
    /** @var DisableTour */
    public $action;

    /** @var TourRepository */
    public $tourRepository;

    public function testActionNotExistingTour(): void
    {
        $this->expectException(NotFoundTourException::class);
        $this->expectExceptionMessage('Not found tour not_existing_tour');

        ($this->action)('not_existing_tour');
    }

    public function testActionTourNotExistInDatabase(): void
    {
        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNull($tour);

        ($this->action)('database_tour_3');
        $this->getManager()->flush();

        $tour = $this->tourRepository->findOneByKeyname('database_tour_3');
        $this->assertNotNull($tour);
        $this->assertTrue($tour->isDisabled());
    }

    public function testActionTourAlreadyExistInDatabase(): void
    {
        $tour = $this->tourRepository->findOneByKeyname('database_tour');
        $this->assertNotNull($tour);
        $this->assertFalse($tour->isDisabled());

        ($this->action)('database_tour');
        $this->getManager()->flush();

        $tour = $this->tourRepository->findOneByKeyname('database_tour');
        $this->assertNotNull($tour);
        $this->assertTrue($tour->isDisabled());
    }
}
