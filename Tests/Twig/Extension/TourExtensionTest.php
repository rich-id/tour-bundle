<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Twig\Extension;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;
use RichId\TourBundle\Twig\Extension\TourExtension;

/**
 * Class TourExtensionTest
 *
 * @package   RichId\TourBundle\Tests\Twig\Extension
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Twig\Extension\TourExtension
 */
#[TestConfig('fixtures')]
final class TourExtensionTest extends TestCase
{
    /** @var TourExtension */
    public $extension;

    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();
        $this->assertCount(5, $functions);
    }

    public function testGetFilters(): void
    {
        $filters = $this->extension->getFilters();
        $this->assertEmpty($filters);
    }

    public function testGetPerformedToursForCurrentUserFetcherNotAuthenticated(): void
    {
        $this->assertSame([], $this->extension->getPerformedToursForCurrentUser());
    }

    public function testGetPerformedToursForCurrentUserFetcher(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertSame(['database_tour_4'], $this->extension->getPerformedToursForCurrentUser());
    }

    public function testGetTours(): void
    {
        $dateOneMonth = new \DateTime('today + 1 month');
        $dateSixMonth = new \DateTime('today + 6 months');

        $this->assertSame(
            [
                'cookie_tour'        => [
                    'storage'     => 'cookie',
                    'duration'    => '+6 months',
                    'expiresDate' => $dateSixMonth->format('Y-m-d'),
                    'isDisabled'  => false,
                ],
                'cookie_tour_2'      => [
                    'storage'     => 'cookie',
                    'duration'    => '+1 months',
                    'expiresDate' => $dateOneMonth->format('Y-m-d'),
                    'isDisabled'  => false,
                ],
                'local_storage_tour' => [
                    'storage'     => 'local_storage',
                    'duration'    => '+6 months',
                    'expiresDate' => $dateSixMonth->format('Y-m-d'),
                    'isDisabled'  => false,
                ],
                'database_tour'      => [
                    'storage'     => 'database',
                    'duration'    => '+6 months',
                    'expiresDate' => $dateSixMonth->format('Y-m-d'),
                    'isDisabled'  => false,
                ],
                'database_tour_2'    => [
                    'storage'     => 'database',
                    'duration'    => '+6 months',
                    'expiresDate' => $dateSixMonth->format('Y-m-d'),
                    'isDisabled'  => true,
                ],
                'database_tour_3'    => [
                    'storage'     => 'database',
                    'duration'    => '+6 months',
                    'expiresDate' => $dateSixMonth->format('Y-m-d'),
                    'isDisabled'  => false,
                ],
                'database_tour_4'    => [
                    'storage'     => 'database',
                    'duration'    => '+6 months',
                    'expiresDate' => $dateSixMonth->format('Y-m-d'),
                    'isDisabled'  => false,
                ],
            ],
            $this->extension->getTours()
        );
    }

    public function testGetToursStatistics(): void
    {
        $this->assertSame(
            [

                'database_tour_4' => 1

            ],
            $this->extension->getToursStatistics()
        );
    }

    public function testIsTourDisabled(): void
    {
        $this->assertTrue($this->extension->isTourDisabled('database_tour_2'));
    }

    public function testIsTourNotDisabled(): void
    {
        $this->assertFalse($this->extension->isTourDisabled('database_tour'));
    }

    public function testHasAccessToTourNotExist(): void
    {
        $this->assertFalse($this->extension->hasAccessToTour('other_database_tour'));
    }

    public function testHasAccessToTourNotAuthenticated(): void
    {
        $this->assertFalse($this->extension->hasAccessToTour('database_tour'));
    }

    public function testHasAccessToTourDIsabled(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertFalse($this->extension->hasAccessToTour('database_tour_2'));
    }

    public function testHasAccessToTour(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertTrue($this->extension->hasAccessToTour('database_tour'));
    }

    public function testHasAccessToTourAlreadyPerformed(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertFalse($this->extension->hasAccessToTour('database_tour_4'));
    }
}
