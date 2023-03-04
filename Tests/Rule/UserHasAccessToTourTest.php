<?php declare(strict_types=1);

namespace RichId\TourBundle\Tests\Rule;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\TourBundle\Rule\UserHasAccessToTour;
use RichId\TourBundle\Tests\Resources\Entity\DummyUser;

/**
 * Class UserHasAccessToTourTest
 *
 * @package   RichId\TourBundle\Tests\Rule
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\TourBundle\Rule\UserHasAccessToTour
 * @TestConfig("fixtures")
 */
final class UserHasAccessToTourTest extends TestCase
{
    /** @var UserHasAccessToTour */
    public $rule;

    public function testUserHasAccessToTourNotExist(): void
    {
        $this->assertFalse(($this->rule)('other_database_tour'));
    }

    public function testUserHasAccessToTourNotAuthenticated(): void
    {
        $this->assertFalse(($this->rule)('database_tour'));
    }

    public function testUserHasAccessToTourDIsabled(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertFalse(($this->rule)('database_tour_2'));
    }

    public function testUserHasAccessToTour(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertTrue(($this->rule)('database_tour'));
    }

    public function testUserHasAccessToTourAlreadyPerformed(): void
    {
        $this->authenticate(DummyUser::class, '1');

        $this->assertFalse(($this->rule)('database_tour_4'));
    }
}
