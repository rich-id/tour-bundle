<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Fetcher;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Fetcher\PerformedToursForCurrentUserFetcher;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

/**
 * Class PerformedToursForCurrentUserFetcherTest
 *
 * @package   RichId\TourBundle\Tests\Fetcher
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Fetcher\PerformedToursForCurrentUserFetcher
 * @TestConfig("fixtures")
 */
final class PerformedToursForCurrentUserFetcherTest extends TestCase
{
    /** @var PerformedToursForCurrentUserFetcher */
    public $fetcher;

    public function testPerformedToursForCurrentUserFetcherNotAuthenticated(): void
    {
        $this->assertSame([], ($this->fetcher)());
    }

    public function testPerformedToursForCurrentUserFetcher(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertSame(['database_tour_4'], ($this->fetcher)());
    }
}
