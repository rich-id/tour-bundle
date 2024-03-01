<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Rule;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Rule\TourExists;

/**
 * Class TourExistsTest
 *
 * @package   RichId\TourBundle\Tests\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Rule\TourExists
 */
#[TestConfig('fixtures')]
final class TourExistsTest extends TestCase
{
    /** @var TourExists */
    public $rule;

    public function testTourExists(): void
    {
        $this->assertTrue(($this->rule)('database_tour_2'));
    }

    public function testTourNotExists(): void
    {
        $this->assertFalse(($this->rule)('other_database_tour'));
    }
}
