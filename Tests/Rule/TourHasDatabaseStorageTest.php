<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Rule;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Rule\TourHasDatabaseStorage;

/**
 * Class TourHasDatabaseStorageTest
 *
 * @package   RichId\TourBundle\Tests\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Rule\TourHasDatabaseStorage
 * @TestConfig("fixtures")
 */
final class TourHasDatabaseStorageTest extends TestCase
{
    /** @var TourHasDatabaseStorage */
    public $rule;

    public function testTourHasDatabaseStorageNotFoundTour(): void
    {
        $this->assertFalse(($this->rule)('other_tour'));
    }

    public function testTourHasDatabaseStorage(): void
    {
        $this->assertTrue(($this->rule)('database_tour_2'));
    }

    public function testTourHasNotDatabaseStorageCookie(): void
    {
        $this->assertFalse(($this->rule)('cookie_tour'));
    }

    public function testTourHasNotDatabaseStorageLocalStorage(): void
    {
        $this->assertFalse(($this->rule)('local_storage_tour'));
    }
}
