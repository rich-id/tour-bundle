<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Rule;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Rule\TourIsDisabled;

/**
 * Class TourIsDisabledTest
 *
 * @package   RichId\TourBundle\Tests\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Rule\TourIsDisabled
 */
#[TestConfig('fixtures')]
final class TourIsDisabledTest extends TestCase
{
    /** @var TourIsDisabled */
    public $rule;

    public function testTourIsDisabled(): void
    {
        $this->assertTrue(($this->rule)('database_tour_2'));
    }

    public function testTourIsNotDisabled(): void
    {
        $this->assertFalse(($this->rule)('database_tour'));
    }
}
