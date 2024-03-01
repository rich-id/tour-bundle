<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Fetcher;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Fetcher\ToursFetcher;

/**
 * Class ToursFetcherTest
 *
 * @package   RichId\TourBundle\Tests\Fetcher
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Fetcher\ToursFetcher
 */
#[TestConfig('fixtures')]
final class ToursFetcherTest extends TestCase
{
    /** @var ToursFetcher */
    public $fetcher;

    public function testToursFetcher(): void
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
            ($this->fetcher)()
        );
    }
}
