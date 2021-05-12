<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Rule;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Rule\IsTourDisabled;

/**
 * Class IsTourDisabledTest
 *
 * @package   RichId\TourBundle\Tests\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Rule\IsTourDisabled
 * @TestConfig("fixtures")
 */
final class IsTourDisabledTest extends TestCase
{
    /** @var IsTourDisabled */
    public $rule;

    public function testIsTourDisabled(): void
    {
        $this->assertTrue(($this->rule)('database_tour_2'));
    }

    public function testIsTourNotDisabled(): void
    {
        $this->assertFalse(($this->rule)('database_tour'));
    }
}
